<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\PaymentInterface;
use App\Http\Requests\AddWalletRequest;

class PaymentController extends Controller
{
    public function __construct(protected PaymentInterface $paymentInterface)
    {
    }

    public function addWallet(AddWalletRequest $request)
    {
        return $this->paymentInterface->addWallet($request);
    }

    public function myWallet()
    {
        return $this->paymentInterface->myWallet();
    }

    public function paymentSale()
    {
        return $this->paymentInterface->paymentSale();
    }
}
