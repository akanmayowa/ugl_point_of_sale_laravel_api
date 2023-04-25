<?php

namespace App\Services;

use App\Helpers\CheckIfdExist;
use App\Helpers\CheckingIdHelpers;
use App\Http\Resources\BusinessSegmentResource;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\CustomerTypeResource;
use App\Models\BusinessSegment;
use App\Models\Customer;
use App\Models\CustomerType;
use App\Traits\ResponseTraits;
use Exception;

class CustomerServices
{
    use ResponseTraits;
    protected $customer;
    protected $customer_type;
    protected $business_segment;

    public function __construct(Customer $customer, CustomerType $customer_type, BusinessSegment $business_segment)
    {
        $this->customer = $customer;
        $this->customer_type = $customer_type;
        $this->business_segment = $business_segment;
    }

    public function index(array $data )
    {
        $customers = $this->customer;

        if(isset($data['name']))
        {
            $customers = $customers->where('name', 'LIKE', '%' . $data['name'] . '%' );
        }

        if(isset($data['email']))
        {
            $customers = $customers->where('email', 'LIKE', '%' . $data['email'] . '%'  );
        }

        if(isset($data['phone_number']))
        {
            $customers = $customers->where('phone_number', 'LIKE', '%' . $data['phone_number']. '%' );
        }

        else{
            $customers = $customers;
        }
        return $this->successResponse($customers->with('customerType','businessSegment')->orderByDesc('id')->paginate(10), 'Customer Successfully Retrieved', 200);
    }

    public function store(array $data)
    {
        $customers = $this->customer->updateOrCreate(
            ['phone_number' => $data['phone_number']],
              [
                'name' => $data['name'],
                'email' => $data['email'],
                 'customer_type_id' => $data['customer_type_id'],
                  'gender' => $data['gender'],
                  'address' => $data['address'] ??  null,
                  'business_segment_id' => $data['business_segment_id'],
            ]);
      return  $this->successResponse(new CustomerResource($customers),'Customer Added or Updated Successfully', 200);
    }


    public function update(array $data, $id)
    {
        try{
        $customers = $this->customer->where('id', $data['id'])->first();
        if(!$customers)
        {
            return $this->errorResponse('Customer Not Found', 401);
        }
        $customers->update($data);
        return  $this->successResponse(new CustomerResource($customers),'Customer Updated Successfully', 200);
      }catch(Exception $exception){
            return $exception;
        }
    }

    public function delete($id)
    {
        try {
                $customers = $this->customer->where('id', $id)->first();
            if (!$customers) {
                    return $this->errorResponse('Customer Not Found', 401);
                }
                $customers->delete();
                return $this->successResponse(null, 'Customer Deleted Successfully', 200);
            }catch(Exception $exception){
           return $exception;
        }
    }

    public function storeCustomerType(array $data)
    {
        if(isset($data['id']))
        {
            $customer_type = $this->customer_type->find($data['id']);
            $customer_type->update($data);
            return $this->successResponse(new CustomerTypeResource($customer_type),'Customer Type Updated Successfully', 200);
        }
        $customer_type = $this->customer_type->updateOrCreate($data);
        return $this->successResponse(new CustomerTypeResource($customer_type),'Customer Type Added Successfully', 200);
    }

    public function indexCustomerType(array $data)
    {
        $customer_type = $this->customer_type->query();
        if(isset($data['types']))
        {
            $customer_type->where('types', 'LIKE', '%' . $data['types']. '%' );
        }
        return $this->successResponse(CustomerTypeResource::collection($customer_type->get()),'Customer Type Retrieved Successfully', 200);
    }

   public function deleteCustomerType($id)
   {
       try {
           $customer = $this->customer_type->where('id', $id)->first();
           if (!$customer) {
               return $this->errorResponse('Customer Type Not Found', 401);
           }
           $customer->delete();
           return $this->successResponse(null, 'Customer Type Successfully Deleted', 200);
       }
        catch(Exception $exception){
           return $exception;
        }
   }

   public function show(array $data)
   {

       $customer = $this->customer::where('id', $data['id'])
                                   ->with(['order' => function ($query){
                                            $query->limit(5);
                                     }])
                                   ->withSum(['transaction' => fn ($query) => $query->where('amount', '!=', null) ], 'amount')
                                    ->firstOrFail();

       if(!$customer)
       {
           return $this->errorResponse('Customer Detail Not Available ', 401);
       }
       return $this->successResponse(new CustomerResource($customer), 'Customer Data Selected Successfully', 200);
   }

   public function showCustomerType(array $data)
   {
       $customer_type = $this->customer_type->where('id', $data['id'])->first();
       if(!$customer_type)
       {
           return $this->errorResponse('Customer Type Not Available', 401);
       }
       return $this->successResponse(new CustomerTypeResource($customer_type), 'Customer Type Data Selected Successfully', 200);
   }

   public function storeBusinessSegment(array $data)
   {
       if(isset($data['id']))
       {
           $businessSegment = $this->business_segment->find($data['id']);
           $businessSegment->update($data);
           return $this->successResponse(new BusinessSegmentResource($businessSegment), 'Operation Successfully', 200);
       }

        $businessSegment = $this->business_segment->updateOrCreate(['name' => $data['name']], ['description' => $data['description'] ?? null]);
        return $this->successResponse(new BusinessSegmentResource($businessSegment), 'Operation Successfully', 200);
   }

   public function deleteBusinessSegment($id)
   {
        CheckingIdHelpers::preventIdDeletion((int)$id, [1,2]);
       try {
           $business_segments = $this->business_segment->where('id', $id)->first();
           if (!$business_segments) {
               return $this->errorResponse('Data Not Found', 401);
           }

           $business_segments->delete();
           return $this->successResponse(null, 'Business Segment Deleted Successfully', 200);
       }
       catch (Exception $exception)
       {
           return $exception;
       }

   }

   public function indexBusinessSegment()
   {
        $business_segments = $this->business_segment->orderBy('name', 'asc')->get();
        return $this->successResponse(BusinessSegmentResource::collection($business_segments), 'All Business Segment Selected Successfully', 200);
   }

   public function showBusinessSegment(array $data)
   {
       return $this->successResponse(new BusinessSegmentResource($this->business_segment->findOrFail($data['id'])), 'Single Business Segment Selected Successfully', 200);
   }

   public function fetchAllCustomerType()
   {
       return $this->successResponse(CustomerTypeResource::collection($this->customer_type->all()), 'All Customer Type Retrieved', 200);
   }

    public function getPriceType(array $data)
    {
        $price_type = $this->customer_type->query()->select('price_type')->where('id', $data['id'])->first();
        return $this->successResponse($price_type,'Selected Price Type Retrieved Successfully', 200);
    }


}
