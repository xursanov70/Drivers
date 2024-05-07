<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\CarInterface;
use App\Http\Requests\AddCarRequest;
use App\Http\Requests\UpdateCarRequest;

class CarController extends Controller
{
    public function __construct(protected CarInterface $carInterface)
    {
    }
    public function addCar(AddCarRequest $request)
    {
        return $this->carInterface->addCar($request);
    }

    public function updateCar(UpdateCarRequest $request)
    {
        return $this->carInterface->updateCar($request);
    }

    public function getCars()
    {
        return $this->carInterface->getCars();
    }

    public function searchCars()
    {
        return $this->carInterface->searchCars();
    }
}
