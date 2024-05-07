<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\UserInterface;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{

    public function __construct(protected UserInterface $userInterface)
    {
    }

    public function register(RegisterRequest $request)
    {
        return $this->userInterface->register($request);
    }

    public function login(LoginRequest $request)
    {
        return $this->userInterface->login($request);
    }

    public function updateUser(UpdateUserRequest $request)
    {
        return $this->userInterface->updateUser($request);
    }

    public function myProfile()
    {
        return $this->userInterface->myProfile();
    }

    public function getUsers()
    {
        return $this->userInterface->getUsers();
    }

    public function searchUsers()
    {
        return $this->userInterface->searchUsers();
    }
}
