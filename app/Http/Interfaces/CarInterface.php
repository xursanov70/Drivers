<?php

namespace App\Http\Interfaces;

use App\Http\Requests\AddCarRequest;
use App\Http\Requests\UpdateCarRequest;

interface CarInterface{
    public function addCar(AddCarRequest $request);
    public function updateCar(UpdateCarRequest $request);
    public function getCars();
    public function searchCars();
}