<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\ChangeUserRoleRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ShowUserRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserIndexRequest;
use Illuminate\Http\Request;
use App\Services\UserServices;


class UserController extends Controller
{

    protected $userServices;

    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
    }

    public function index(UserIndexRequest $userIndexRequest)
    {
        return $this->userServices->index($userIndexRequest->all());
    }

    public function show(ShowUserRequest $showUserRequest)
    {
        return $this->userServices->showUser($showUserRequest->all());
    }

    public function update(UpdateUserRequest $updateUserRequest)
    {
        return $this->userServices->updateProfile($updateUserRequest->all());
    }

    public function changePassword(ChangePasswordRequest $changePasswordRequest)
    {
        return $this->userServices->changePassword($changePasswordRequest->all());
    }

    public function changeStatus(ChangeStatusRequest $changePasswordRequest)
    {
        return $this->userServices->changeStatus($changePasswordRequest->all());
    }


    public function authUser()
    {
        return $this->userServices->authenticatedUser();
    }

    public function changeUserRole(ChangeUserRoleRequest  $changeUserRoleRequest)
    {
        return $this->userServices->changeUserRole($changeUserRoleRequest->all());
    }

    public function updateUserProfile(UpdateProfileRequest $updateProfileRequest)
    {
        return $this->userServices->updateUserProfile($updateProfileRequest->all());
    }

}
