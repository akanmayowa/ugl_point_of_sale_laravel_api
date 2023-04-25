<?php

namespace App\Services;

use App\Helpers\CheckingIdHelpers;
use App\Http\Resources\OrderDetailsResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\TransactionResource;
use App\Models\BusinessSegment;
use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\Debtor;
use App\Models\DebtorDetail;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Transaction;
use App\Models\User;
use App\Traits\ResponseTraits;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderServices
{

    use ResponseTraits;

    public const OnCredit = 'on-credit';
    public const GenderOther = 'other';
    public const PhoneNumber = '070-1234-1234';
    public const Name = 'walk-in-customer';
    public const Email =  'customer@ugl-pos.com';
    public const Address = 'Lagos - Nigeria';
    public const WalkInCustomer = 4;

    protected $order;
    protected $order_details;
    protected $transaction;
    protected $customer;
    protected $inventory;
    protected $debtor;
    protected $debtor_details;
    protected $business_segment;
    protected $user;

    public function __construct(User $user, BusinessSegment $business_segment,Order $order, OrderDetail $order_details, Transaction $transaction, Customer $customer, Inventory $inventory, Debtor $debtor, DebtorDetail $debtor_details)
    {
        $this->user = $user;
        $this->order = $order;
        $this->order_details = $order_details;
        $this->transaction = $transaction;
        $this->customer = $customer;
        $this->inventory = $inventory;
        $this->debtor = $debtor;
        $this->debtor_details = $debtor_details;
        $this->business_segment = $business_segment;

    }

    /**
     * @throws \Exception
     */
    public function store(array $data)
    {
        $StockService = new StockServices();
        $StockService->checkStockLevels($data['items']);
        try {
            DB::beginTransaction();
            $data['transaction_mode_id'] === 4 ? $data['payment_type'] = 'on-credit' : $data['payment_type'] = 'complete-payment';
            $authUser = auth()->user();
            $orderData = [
                'order_number' => (new \App\Helpers\GenerateRandomNumber)->uniqueRandomNumber( 'UGL-ODR-',10),
                'order_date' => Carbon::now()->toDateTimeString(),
                'staff_id' => $authUser->staff_id,
                'user_id' => $authUser->id,
                'payment_type' => $data['payment_type'] ?? self::OnCredit,
                'branch_id' => $authUser->branch_id,
            ];
            $order = $this->order->create($orderData + $data);
            foreach ($data['items'] as $key => $item)
            {
                $amount = $item['quantity'] * $item['price'];
                $orderDetails = [
                    'order_id' => $order->id,
                    'inventory_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'amount' => $amount,
                    'branch_id' => $authUser->branch_id,
                ];
                $this->order_details->create($orderDetails);
            }
            $transactionData = [
                'reference_number' => (new \App\Helpers\GenerateRandomNumber)->uniqueRandomNumber( 'UGL-TRN-',10),
                'staff_id' => $authUser->staff_id,
                'user_id' => $authUser->id,
                'order_id' => $order->id,
                'customer_id' => $data['customer_id'],
                'transaction_mode_id' => $data['transaction_mode_id'],
                'transaction_date' => Carbon::now(),
                'description' => "Payment For Inventory Items With Order Number: , " . $order['order_number'],
                'amount' => $data['total'],
                'branch_id' => $authUser->branch_id,
            ];
            $this->transaction->create($transactionData);
            if($data['transaction_mode_id'] == 4) $this->debtor($data, $order);   // payment method or payment type for debtors
            DB::commit();
            return $this->successResponse(new OrderResource($order), 'Order Created Successfully', 200);
        } catch (\Exception $exception) {
            DB::rollback();
            return $exception;
        }
    }

    public function orderDetails(array $data)
    {
        $authUser  = Auth::user();
        $order_detail = [];
        foreach ($data['items'] as $key => $item) {
            $orderDetails = [
                'order_id' => $data['order_id'],
                'inventory_id' => $item['inventory_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'branch_id' => $authUser->branch_id,
            ];
            $order_detail[] = $this->order_details->create($orderDetails);
        }
        return $this->successResponse(OrderDetailsResource::collection($order_detail), 'Inventory Items Added Successfully', 200);
    }

    public function orderTransaction(array $data)
    {
        $authUser  = Auth::user();
        $transactionData = [
            'reference_number' => (new \App\Helpers\GenerateRandomNumber)->uniqueRandomNumber('UGL-TRN', 10),
            'staff_id' => auth()->user()->staff_id,
            'user_id' => auth()->user()->id,
            'order_id' => $data['order_id'],
            'customer_id' => $data['customer_id'],
            'transaction_mode_id' => $data['transaction_mode_id'],
            'transaction_date' => Carbon::now(),
            'description' => "Payment For Inventory Item, " . $data['order_id'],
            'amount' => $data['amount'],
            'branch_id' => $authUser->branch_id,
        ];
        $transaction = $this->transaction->create($transactionData);
        return $this->successResponse(new TransactionResource($transaction), 'Transaction Saved Successfully', 200);
    }


    public function index(array $data)
    {
        $orders = CheckingIdHelpers::checkAuthUserBranch($this->order);
        $orders = $orders->with('customer:id,name', 'employee:id,first_name,last_name',
                                                        'orderDetail:id,order_id,inventory_id,price,quantity,amount',
                                                        'orderDetail.inventory:id,name');
        if (isset($data['order_number'])) {
            $orders->where('order_number', 'like', '%' . $data['order_number'] . '%')->orderByDesc('id');
        }
        return $this->successResponse($orders->orderByDesc('id')->paginate(10), 'All Orders Selected Successfully', 200);
    }

    public function show($id)
    {
        $orders = $this->order->where('id', $id)->with('employee.branch')->firstOrFail();
        return $this->successResponse(new OrderResource($orders), 'Fetch Single Order', 200);
    }

    public function fetchAllCustomer(array $data)
    {
        $perPage = isset($data['limit']) ? $data['limit'] : 10;
        $customer = $this->customer->query();
        if (isset($data['search'])) {
            $search = $data['search'];
            $customer = $customer->where('name', 'LIKE', '%' . $search . '%');
        }
        return $this->successResponse($customer->paginate($perPage), 'Fetch All Customer', 200);
    }


    public function fetchAllInventory(array $data): array
    {
        $search = $data['search'] ?? null;
        $perPage = $data['limit'] ?? 10;
        $customer = $this->customer->firstRecord($data['customer_id']);
        $inventories = $this->inventory->getInventoryWithCategory($search, $perPage);

        $customerType = $customer->customerType->types;

       if($customerType  === CustomerType::Retail){
          $inventories = $this->inventoryMap($inventories,'price');
        }

         if($customerType  === CustomerType::Dealer){
            $inventories = $this->inventoryMap($inventories, 'dealer_price');
        }

         if($customerType  === CustomerType::Staff){
            $inventories = $this->inventoryMap($inventories,'staff_price');
        }

         if($customerType  === CustomerType::Crs){
            $inventories = $this->inventoryMap($inventories,'crs_price');
        }

        return [
                'data' => $inventories,
                'message' => 'Fetch All Inventory',
                'statusCode' => 200,
                'status' => true
        ];
    }

    public function inventoryMap($inventories,$value)
    {
         return   $inventories->through(static function ($items) use ($value){
                return [
                    'id' => $items->id,
                    'name' => $items->name,
                    'price' =>  $items[$value] ?? $items['price'],
                    'quantity' => $items->quantity,
                    'unit_of_measurement' => $items->unit_of_measurement,
                    'category' => $items->categories
                ];
            });
    }

    public function debtor($data, $order)
    {
                $debtor = $this->debtor->create(['debtor_number' => (new \App\Helpers\GenerateRandomNumber)->uniqueRandomNumber( 'UGL-DEBT-',10),
                                            'order_id' => $order->id,
                                            'user_id' => auth()->user()->id,
                                            'order_number' => $order->order_number,
                                            'customer_id' => $data['customer_id'],
                                            'total_amount' => $order->total,
                                            'discount' => $data['discount'] ?? 0,
                                            'payment_duration' => $data['payment_duration'] ?? 0,
                                            'payment_date' => $data['payment_date'] ?? Carbon::now(),
                                            'branch_id' => Auth::user()->branch_id,
                                        ]);
                $debtor->debtorDetails()->create($this->debtorDetailData($debtor, $data));
    }

    public function debtorDetailData($debtor, $data)
    {
        $authUser  = Auth::user();
        return [
            'debtor_id' => $debtor->id,
            'debtor_number' => $debtor->debtor_number,
            'initial_payment' => $data['initial_payment'] ?? 0,
            'total_amount' => $debtor->total_amount,
            'discount' => $data['discount'] ?? 0,
            'user_id' => auth()->user()->id,
            'payment_date' => $data['payment_date'] ?? Carbon::now()->format('Y-m-d'),
            'branch_id' => $authUser->branch_id,
        ];
    }

    public function fetchAllOrders(array $data)
    {
        $getALlOrder = CheckingIdHelpers::checkAuthUserBranch($this->order);
        $getALlOrder = $getALlOrder->select('id', 'order_number', 'branch_id');
        if (isset($data['search'])) {
            $search = $data['search'];
            $getALlOrder->where(function ($query) use ($search) {
                $query->orWhere('id', 'like', '%' . $search . '%');
                $query->orWhere('order_number', 'like', '%' . $search . '%');
            })->orderBy('id', 'desc');
        }
        $limit = $data['limit'] ?? 50;
        $getALlOrder = $getALlOrder->orderByDesc('id');
        return $this->successResponse($getALlOrder->paginate($limit),'All Retrieved Successfully', 200);
    }

    public function getCashierByOrderId($data)
    {
        $orderId = $data['order_id'];
        $user = $this->user->with(['branch'])->whereHas('order', function (Builder $query) use ($orderId){
                                              $query->where('id', $orderId); })
                                              ->firstOrFail();
        return [
            'data' => $user,
            'message' => 'Employee Data Fetched SuccessFully',
            'statusCode' => 200,
            'status' => true
        ];
    }

}
