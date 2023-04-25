<?php

namespace App\Services;

use App\Enums\UserRoleEnums;
use App\Enums\UserStatusEnums;
use App\Helpers\CheckingIdHelpers;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\PasswordResetNotification;
use App\Traits\ResponseTraits;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserServices
{
    use ResponseTraits;
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index(array $data)
    {
        $user = CheckingIdHelpers::checkAuthUserBranch($this->user);
        $user =  $user->where('user_role', $data['user_role']);

        if(isset($data['user_status']))
        {
            $users = $user->where('user_status' , 'Like', '%' . $data['user_status']. '%');
        }
       elseif(isset($data['name']))
       {
           $search = $data['name'];
           $userRole = $data['user_role'];
          $users = $user->where( function($query) use ($search, $userRole) {
                       $query->where('user_role', $userRole)->where( function ($query) use ($search) {
                           $query->OrWhere('first_name' , 'Like', '%' . $search. '%')
                               ->OrWhere('last_name' , 'Like', '%' . $search. '%')
                               ->orWhere(DB::raw('CONCAT(first_name," ",last_name)'),'like','%'.$search.'%');
                       });
          });
       }
       elseif(isset($data['staff_id']))
       {
           $users = $user->where('staff_id' , 'Like', '%' . $data['staff_id'] . '%');
       }
        elseif (isset($data['email']))
        {
            $users = $user->where('email' , 'Like', '%' . $data['email'] . '%');
        }
        else{
            $users = $user;
        }

//        return $this->successResponse($this->paginate(UserResource::collection($users->get())), 'All User Details Retrieved SuccessFully', 202);
        return $this->successResponse($users->with('branch')->orderByDesc('id')->paginate(10), 'All User Details Retrieved SuccessFully', 200);
    }

    public function updateProfile(array $data)
    {
        $id = $data['id'];
        $user = $this->user->where('id', $id)->with('branch')->first();
        if(!$user){
            return $this->errorResponse('User Not Found', 401);
        }
        $userData = [
            'first_name' => $data['first_name'] ?? $user->first_name,
            'last_name' => $data['last_name'] ?? $user->last_name,
            'gender' => $data['gender']  ?? $user->gender,
            'branch_id' => $data['branch_id'] ?? $user->branch_id,
            'phone_no' => $data['phone_no'] ?? $user->phone_no,
        ];
        $user->update($userData);
        return $this->successResponse($user, "User Detail Updated Successfully",200);
    }

    public function changePassword(array $data)
    {
        if(!Hash::check($data['current_password'], auth()->user()->password))
        {
           return $this->errorResponse("Old Password Doesn't match!", 401);
        }

        $new_password = bcrypt($data['new_password']);
        if(Hash::check($data['current_password'], $new_password))
        {
            return $this->errorResponse("Current Password Cant Be Your New Password");
        }

        $user =  $this->user::whereId(auth()->user()->id)->first();
        $user->update(['password' => Hash::make($data['new_password'])]);
        return $this->successResponse(new UserResource($user),"Password Change SuccessFully", 200);
    }

    public function showUser(array $data)
    {
        $user = $this->user->where('id', $data['id'])->with('branch')->first();
        if(!$user)
        {
            return $this->errorResponse('User Doesnt Exist', 401);
        }
        return $this->successResponse($user,'Single User Detail Selected Successfully', 200);
    }

    public function authenticatedUser()
    {
        $user = $this->user->where('id', auth()->user()->id)->with('branch')->first();
        return $this->successResponse($user,'Logged In User Data Selected', 200);
    }

    public function changeStatus(array $data)
    {
        $user =  $this->user->where('id', $data['id'])->first();
        if(!$user)
        {
            return $this->errorResponse('User Doesnt Exist', 401);
        }

        if($user->user_status === UserStatusEnums::Activated)
        {
            $user->update(['user_status' => UserStatusEnums::Deactivated]);
            return $this->successResponse(new UserResource($user), "User Deactivated Successful", 200);
        }

        $user->update(['user_status' => UserStatusEnums::Activated]);
        return $this->successResponse(new UserResource($user), "User Activated Successful", 200);
    }

    public function changeUserRole(array $data)
    {
        $user =  $this->user->where('id', $data['id'])->first();
        if(!$user)
        {
            return $this->errorResponse('User Doesnt Exist', 401);
        }

        if($user->user_role === UserRoleEnums::Admin)
        {
            $user->update(['user_role' => UserRoleEnums::Cashier]);
            return $this->successResponse(new UserResource($user), "User Deactivated Successful", 200);
        }

        $user->update(['user_role' => UserRoleEnums::Admin]);
        return $this->successResponse(new UserResource($user), "User Activated Successful", 200);
    }

    public function updateUserProfile(array $data)
    {
        $user =  $this->user->where('id', auth()->user()->id)->with('branch')->first();
        if(!$user)
        {
            return $this->errorResponse('User Doesnt Exist', 401);
        }
        $user->update($data);
        return $this->successResponse($user, "User Successful", 200);
    }

}
