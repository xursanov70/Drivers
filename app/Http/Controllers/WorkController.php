<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\WorkInterface;
use App\Http\Requests\SendRequest;

class WorkController extends Controller
{

    public function __construct(protected WorkInterface $workInterface){

    }
    public function getUnemployed()
    {
        return $this->workInterface->getUnemployed();
    }

    public function sendRequest(SendRequest $request)
    {
        return $this->workInterface->sendRequest($request);
    }

    public function getJob()
    {
        return $this->workInterface->getJob();
    }

    public function acceptJob(int $work_id)
    {
        return $this->workInterface->acceptJob($work_id);
    }

    public function startWork(int $work_id)
    {
        return $this->workInterface->startWork($work_id);
    }

    public function endWork(int $work_id)
    {
        return $this->workInterface->endWork($work_id);
    }

    public function myWorks()
    {
        return $this->workInterface->myWorks();
    }

    public function myOrders()
    {
        return $this->workInterface->myOrders();
    }

    public function getNotify(){
        return $this->workInterface->getNotify();
    }
}
