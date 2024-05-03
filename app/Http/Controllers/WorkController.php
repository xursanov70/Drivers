<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendRequest;
use App\Http\Resources\GetJobResource;
use App\Models\User;
use App\Models\WorkTime;
use App\Notifications\Notify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkController extends Controller
{
    public function getUnemployed()
    {
        return User::select('username', 'phone')->where('users.active', true)
            ->where('user_type', 'worker')
            ->where('users.user_payment', true)
            ->where('users.work_time', false)
            ->where('users.payment_time', date('Y-m-d'))
            ->orderBy('users.username', 'asc')
            ->paginate(15);
    }

    public function sendRequest(SendRequest $request)
    {
        try {
            $workTime = WorkTime::create([
                'user_id' => auth()->user()->id,
                'lat' => $request->lat,
                'lang' => $request->lang,
            ]);
    
            $users = User::select('*')
                ->where('users.active', true)
                ->where('user_type', 'worker')
                ->where('users.user_payment', true)
                ->where('users.work_time', false)
                ->where('users.payment_time', date('Y-m-d'))
                ->get();
    
            $work = "https://www.google.com/maps?q=" . "$workTime->lang,$workTime->lat";

            foreach ($users as $user){
                $user->notify(new Notify($work));
            }
    
    
            return response()->json(["message" => "So'rov yuborildi. Iltimos kuting!"], 200);
        } catch (\Exception $exception) {
            return response()->json([
                "message" => "So'rov yuborishda xatolik yuz berdi",
                "error" => $exception->getMessage(),
                "line" => $exception->getLine(),
                "file" => $exception->getFile()
            ]);
        }
    }

    public function getJob()
    {
        $work = WorkTime::select('*')
            ->where('work_times.active', true)
            ->join('users', 'users.id', '=', 'work_times.user_id')
            ->paginate(15);
        return GetJobResource::collection($work);
    }

    public function acceptJob(int $work_id)
    {

        $auth = auth()->user()->id;
        $user = User::select('*')->where('users.id', $auth)
            ->where('user_type', 'worker')
            ->where('users.user_payment', true)
            ->where('users.work_time', false)
            ->where('users.payment_time', date('Y-m-d'))->first();

        if ($user) {
            $work = WorkTime::select('*')
                ->where('id', $work_id)
                ->where('active', true)
                ->first();
            if (!$work) {
                return response()->json(["message" => "Mijoz mavjud emas!"], 404);
            } else {
                $work->worker_id = $auth;
                $work->active = false;
                $work->accept_time = date('Y-m-d H:i:s');
                $work->save();
                return response()->json(["message" => "Mijozni qabul qilganingiz tasdiqlandi!"], 200);
            }
        } else {
            return response()->json(["message" => "Amaliyotga huquqingiz yo'q!"], 403);
        }
    }

    public function startWork(int $work_id)
    {

        $auth = auth()->user()->id;

        $user = User::select('*')->where('users.id', $auth)
            ->where('user_type', 'worker')
            ->where('users.user_payment', true)
            ->where('users.work_time', false)
            ->where('users.payment_time', date('Y-m-d'))->first();

        if ($user) {
            $work = WorkTime::select('*')
                ->where('id', $work_id)
                ->where('worker_id', $auth)
                ->where('active', false)
                ->where('start_work', null)
                ->first();
            if (!$work) {
                return response()->json(["message" => "Mijoz mavjud emas!"], 404);
            } else {
                $work->start_work = date('Y-m-d H:i:s');
                $work->save();
                return response()->json(["message" => "Ish boshlandi!"], 200);
            }
        } else {
            return response()->json(["message" => "Amaliyotga huquqingiz yo'q!"], 403);
        }
    }

    public function endWork(int $work_id)
    {

        $auth = auth()->user()->id;

        $user = User::select('*')->where('users.id', $auth)
            ->where('user_type', 'worker')
            ->where('users.user_payment', true)
            ->where('users.work_time', false)
            ->where('users.payment_time', date('Y-m-d'))->first();

        if ($user) {
            $work = WorkTime::select('*')
                ->where('id', $work_id)
                ->where('worker_id', $auth)
                ->where('active', false)
                ->where('start_work', '!=', null)
                ->where('end_work', null)
                ->first();
            if (!$work) {
                return response()->json(["message" => "Mijoz mavjud emas!"], 404);
            } else {
                $work->end_work = date('Y-m-d H:i:s');
                $work->save();
                return response()->json(["message" => "Ish tugatildi!"], 200);
            }
        } else {
            return response()->json(["message" => "Amaliyotga huquqingiz yo'q!"], 403);
        }
    }

    public function myWorks()
    {
        $auth = auth()->user()->id;

        return WorkTime::select('username', 'accept_time', 'start_work', 'end_work')
            ->join('users', 'users.id', '=', 'work_times.user_id')
            ->where('worker_id', $auth)
            ->where('work_times.active', false)
            ->where('start_work', '!=', null)
            ->where('end_work', '!=', null)
            ->orderBy('work_times.id', 'asc')
            ->paginate(15);
    }

    public function myOrders()
    {
        $auth = auth()->user()->id;

        return WorkTime::select('username', 'accept_time', 'start_work', 'end_work')
            ->join('users', 'users.id', '=', 'work_times.worker_id')
            ->where('user_id', $auth)
            ->where('work_times.active', false)
            ->where('start_work', '!=', null)
            ->where('end_work', '!=', null)
            ->orderBy('work_times.id', 'asc')
            ->paginate(15);
    }

    public function getNotify(){
        return DB::table('notifications')->select('data')
        ->where('notifiable_id', auth()->user()->id)->paginate(15);
    }
}
