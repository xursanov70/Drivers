<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\CarInterface;
use App\Http\Requests\AddCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Car;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CarRepository implements CarInterface
{

    public function addCar(AddCarRequest $request)
    {
        $user = User::find(Auth::user()->id);

        Car::create([
            'car_name' => $request->car_name,
            'car_number' => $request->car_number,
            'user_id' => $user->id,
        ]);

        $user->user_type = 'worker';
        $user->save();

        return response()->json(["message" => "Mashina muvaffaqqiyatli kiritildi!"], 201);
    }

    public function updateCar(UpdateCarRequest $request)
    {

        $car = Car::where('user_id', auth()->user()->id)
            ->where('active', true)
            ->first();

        $car->update([
            'car_name' => $request->car_name,
        ]);

        return response()->json(["message" => "Mashina kiritish muvaffaqqiyatli o'zgartirildi!"], 200);
    }

    public function getCars()
    {

        return Car::select('username', 'car_name', 'car_number')
            ->where('cars.active', true)
            ->where('users.active', true)
            ->join('users', 'users.id', '=', 'cars.user_id')
            ->orderby('car_name', 'asc')
            ->paginate(15);
    }

    public function searchCars()
    {

        $search = request('search');

        return Car::select('username', 'car_name', 'car_number')
            ->where('cars.active', true)
            ->where('users.active', true)
            ->join('users', 'users.id', '=', 'cars.user_id')
            ->when($search, function ($query) use ($search) {
                $query->orWhere('car_name', 'like', "%$search%")
                    ->orWhere('car_number', 'like', "%$search%");
            })
            ->orderby('car_name', 'asc')
            ->paginate(15);
    }
}
