<?php

namespace App\Http\Interfaces;

use App\Http\Requests\SendRequest;

interface WorkInterface{
    public function getUnemployed();
    public function sendRequest(SendRequest $request);
    public function getJob();
    public function acceptJob(int $work_id);
    public function startWork(int $work_id);
    public function endWork(int $work_id);
    public function myWorks();
    public function myOrders();
    public function getNotify();
}