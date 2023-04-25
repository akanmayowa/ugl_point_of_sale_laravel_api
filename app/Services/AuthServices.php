<?php

namespace App\Services;

use App\Enums\UserStatusEnums;
use App\Helpers\GenerateRandomNumber;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\PasswordResetNotification;
use App\Traits\ResponseTraits;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class AuthServices
{
    use ResponseTraits;
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login(array $data)
    {
        $user = $this->user->where('email', $data['email'])->first();
        if($user->user_status === UserStatusEnums::Deactivated)
        {
            return $this->errorResponse('User Account Deactivated', 401);
        }
        $credentials = [
            'email' => $data['email'],
            'password' => $data['password']
        ];
        $token = auth('api')->attempt($credentials);

        if (!$token)
        {
            return $this->errorResponse('Wrong User Email or Password',401);
        }

        $users = [
            'user' => $user,
            'authorisation' => [ 'token' => $token,  'type' => 'bearer', ]
        ];
        return $this->successResponse($users,'User Login SuccessFully',201);
    }

    public function register(array $data)
    {
        if(!isset($data['staff_id']))
        {
            $data['staff_id'] =  (new \App\Helpers\GenerateRandomNumber)->uniqueRandomNumber('UGL-STAFF-',10);
        }

        if(!isset($data['password']))
        {
            $data['password'] = bcrypt('123456');
        }
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone_no' => $data['phone_no'],
            'staff_id' => $data['staff_id'],
            'gender' => $data['gender'],
            'branch_id' => $data['branch_id'],
            'password' => bcrypt($data['password']),
            'user_role' => $data['role']
        ]);
         $user =  $this->user->where('id', $user->id)->get();
        return $this->successResponse(UserResource::collection($user),'User Registration Successfully', 201);
    }

    public function refresh()
    {
          $data =  [
            'user' => auth()->user(),
            'authorisation' => [ 'token' => auth()->refresh(), 'type' => 'bearer']
          ];
        return $this->successResponse($data,'User Registration Successfully', 201);
    }

    public function forgetPassword(array $data)
    {
        $user = $this->user->where('email', '=', $data['email'])->first();

        if (!$user)
        {
            return $this->errorResponse(trans('User does not exist'));
        }

        DB::table('password_resets')->insert([
            'email' => $data['email'],
            'token' => str::random(60),
            'created_at' => Carbon::now()
        ]);

        $tokenData = DB::table('password_resets')->where('email', $data['email'])->first();

        if ($this->sendResetEmail($user, $data['email'], $tokenData->token))
        {
            return $this->successResponse(null,'A Password Reset Token Has Been Sent To Your Email Address.', 200);
        } else {
            return $this->errorResponse('A Network Error occurred. Please try again.',401);
        }
    }

    private function sendResetEmail(User $user, string $email, string $token)
    {
        $userData['first_name'] = $user['first_name'];
        $userData['last_name'] = $user['last_name'];
        $userData['email'] = $email;
        $userData['token'] = $token;
        $user->notify(new PasswordResetNotification($userData));
        try {
            return true;
        } catch (Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 401);
        }
    }

    public function resetPassword(array $data)
    {
        $tokenData = DB::table('password_resets')->where('token', $data['token'])->first();
        $user = $this->user::where('email', $tokenData->email)->first();
        if (!$tokenData) {
            return $this->errorResponse('Invalid Token', 401);
        }

        if (!$user) {
              return $this->errorResponse('Email not found');
          }

        $user->update(['password' => bcrypt($data['password'])]);
        if($user)
        {
            DB::table('password_resets')->where('email', $user->email)->delete();
            return $this->successResponse(null, "User Password Reset Successfully",200);
        }
        else {
            return $this->errorResponse('A Network Error occurred. Please try again.',401);
        }
    }

}
