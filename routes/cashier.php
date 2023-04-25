<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\Cashier\DashBoardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaymentDurationController;
use App\Http\Controllers\TransactionModeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


//Route::middleware('auth:api')->group(function () {
        Route::group(['middleware' => ['cashier']], function () {

            Route::controller(DashBoardController::class)->group(function () {
                Route::prefix('dashboard')->group(function () {
                    Route::get('counter', 'index');
                    Route::get('debtors-still-owing', 'fetchAllDebtorStillOwing');
                });
            });

                Route::prefix('orders')->group(function () {
                    Route::get('index', [\App\Http\Controllers\Cashier\OrderController::class,'index']);
                    Route::post('store', [\App\Http\Controllers\OrderController::class  ,'store']);
                    Route::get('show/{id}', [\App\Http\Controllers\OrderController::class  ,'show']);
                    Route::get('user-order',[\App\Http\Controllers\OrderController::class  ,'getCashierByOrderId']);
                });
          });

                Route::get('fetch-all-inventory', [\App\Http\Controllers\OrderController::class,'fetchAllInventory']);
                Route::get('fetch-all-customer', [\App\Http\Controllers\OrderController::class,'fetchAllCustomer']);


                Route::controller(PaymentDurationController::class)->group(function () {
                    Route::prefix('payment-duration')->group(function () {
                        Route::get('index', 'index');
                        Route::get('show', 'show');
                    });
                });

        Route::controller(BankController::class)->group(function () {
            Route::prefix("banks")->group(function () {
                Route::get('/', 'index');
                Route::get("edit", "edit");
            });
        });


        Route::controller(BranchController::class)->group(function () {
            Route::prefix('branch')->group(function () {
                Route::get('/', 'index');
                Route::get("edit", "edit");
            });
        });


        Route::controller(CustomerController::class)->group(function () {
            Route::prefix('customer')->group(function () {
                Route::get('index', 'index');
                Route::get('show', 'show');
                Route::post('store', 'store');
            });
        });

            Route::prefix('debtors')->group(function () {
                Route::get('index', [\App\Http\Controllers\Cashier\DebtorController::class,'index']);
                Route::post('store', [\App\Http\Controllers\DebtorController::class,'store']);
                Route::get('show', [\App\Http\Controllers\DebtorController::class, 'show']);
                Route::post('customer-debt-payment', [\App\Http\Controllers\DebtorController::class,'customerDebtPayment']);
                Route::get('fetch-all-order', [\App\Http\Controllers\Cashier\DebtorController::class,'fetchAllCustomerOrders']);
        });


            Route::controller(UserController::class)->group(function () {
                Route::prefix('user')->group(function () {
                    Route::get('index', 'index');
                    Route::post('change-password', 'changePassword');
                    Route::get('show', 'show');
                    Route::post('update', 'update');
                    Route::get('authenticated', 'authUser');
                    Route::post('update-profile', 'updateUserProfile');
                });
            });


            Route::controller(TransactionModeController::class)->group(function () {
                Route::prefix('payment-mode')->group(function () {
                    Route::get('/', 'index');
                    Route::get('show', 'show');
                });
            });


            Route::controller(CustomerController::class)->group(function () {
                Route::prefix('customer-type')->group(function () {
                    Route::get('index', 'indexCustomerType');
                    Route::post('store', 'storeCustomerType');
                    Route::get('show', 'showCustomerType');
                    Route::get('fetch-all', 'fetchCustomerType');
                    Route::get('fetch-price-type', 'getPriceType');
                });
            });

            Route::controller(CustomerController::class)->group(function () {
                Route::prefix('business-segment')->group(function () {
                    Route::get('index', 'indexBusinessSegment');
                    Route::get('show', 'showBusinessSegment');
                    Route::post('store', 'storeBusinessSegment');
                });
            });

//});
