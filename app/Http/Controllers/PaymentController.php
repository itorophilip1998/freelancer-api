<?php

namespace App\Http\Controllers;

use  Unzer; 
use UnzerSDK;

class PaymentController extends Controller
{

    public function makePayment()
    { 
        $unzer = new Unzer(env("UNZER_S_PRI"));

        $paypal = new UnzerSDK();
        $paypal = $unzer->createPaymentType($paypal);
        return $paypal;
    }
}
