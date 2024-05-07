<?php

namespace App\Http\Interfaces;

use App\Http\Requests\AddWalletRequest;

interface PaymentInterface{
    public function addWallet(AddWalletRequest $request);
    public function myWallet();
    public function paymentSale();
}