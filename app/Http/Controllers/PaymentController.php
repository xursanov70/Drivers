<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddWalletRequest;
use App\Models\Payment;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function addWallet(AddWalletRequest $request)
    {

        Wallet::create([
            'user_id' => auth()->user()->id,
            'code' => $request->code,
            'expire_date' => $request->expire_date,
        ]);

        return response()->json(["message" => "Karta muvaffaqqiyatli qo'shildi!"], 201);
    }

    public function myWallet()
    {
        return Wallet::select('username', 'code', 'expire_date')
            ->where('user_id', auth()->user()->id)
            ->join('users', 'users.id', '=', 'wallets.user_id')
            ->first();
    }

    public function paymentSale()
    {

        $user = User::find(Auth::user()->id);

        $payment = Payment::orderBy('id', 'desc')->first();

        $wallet = Wallet::where('user_id', $user->id)->first();

        if ($payment->payment_amount > $wallet->wallet_sum) {
            return response()->json(["message" => "Hisobingizda yetarli mablag' mavjud emas!"], 403);
        } else {
            $wallet->wallet_sum -= $payment->payment_amount;
            $user->user_payment = true;
            $user->payment_time = date('Y-m-d');
            $user->save();
            $wallet->save();

            return response()->json(["message" => "To'lov muvaffaqqiyatli amalga oshirildi!"], 200);
        }
    }
}
