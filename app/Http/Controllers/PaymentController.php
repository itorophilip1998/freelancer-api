<?php

namespace App\Http\Controllers;

use UnzerSDK\Unzer;
use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use Facade\Ignition\DumpRecorder\Dump;
use UnzerSDK\Resources\PaymentTypes\Paypal;

class PaymentController extends Controller
{

    public function makePayment()
    {
        dump(env("UNZER_S_PRI"), request()->all());
        $unzer = new Unzer(env("UNZER_S_PRI"));

        $paypal = new Paypal();
        $paypal = $unzer->createPaymentType($paypal);
    }
}
