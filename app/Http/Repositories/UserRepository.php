<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\UserInterface;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserInterface
{

    public function register(RegisterRequest $request)
    {

        $user = User::create([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        $token = $user->createToken('auth-token')->plainTextToken;
        return response()->json(["message" => "Ro'yxatdan muvaffaqqiyatli o'tdingiz!", "token" => $token], 201);
    }

    public function login(LoginRequest $request)
    {
        $login = [
            'username' => $request->username,
            'password' => $request->password

        ];

        if (Auth::attempt($login)) {
            $user = $request->user();
            $token = $user->createToken('auth-token')->plainTextToken;
            return response()->json(['token' => $token, 'success' => true], 200);
        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }

    public function updateUser(UpdateUserRequest $request)
    {
        $user = User::find(Auth::user()->id);
        $user->update([
            'full_name' => $request->full_name,
        ]);
        return response()->json(["message" => "User muvaffaqqiyatli o'zgartirildi!"], 200);
    }

    public function myProfile()
    {
        return Auth::user();
    }

    public function getUsers()
    {
        return User::orderBy('username', 'asc')->paginate(15);
    }

    public function searchUsers()
    {
        $search = request('search');
        $auth = Auth::user()->id;

        return  User::where('id', '!=', $auth)
            ->where('active', true)
            ->when($search, function ($query) use ($search) {
                $query->where('username', 'like', "%$search%")
                    ->orWhere('full_name', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%");
            })
            ->orderBy('users.username', 'asc')
            ->paginate(15);
    }
}
