<?php

namespace App\Http\Interfaces;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;

interface UserInterface{
    public function register(RegisterRequest $request);
     public function login(LoginRequest $request);
     public function updateUser(UpdateUserRequest $request);
     public function myProfile();
     public function getUsers();
     public function searchUsers();
}