<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Withdrawal;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWalletRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateWalletRequest;

class WalletController extends Controller
{


    public function wallet()
    {

        try {
            if (!auth()->check()) {
                return response()->json(['message' => 'Unauthorized ⚠️'], 401);
            }
            $user = auth()->user();
            $wallet = Wallet::where(['user_id' => $user->id])->first();

            if (!$wallet) {
                return response()->json(['message' => "You cant update your wallet"], 401);
            }

            $transactions = Withdrawal::where("user_id", $user->id)->with("user")->get();
            $data = [
                'wallet' => $wallet,
                'widthdrawals' => $transactions,
            ];

            return response()->json(['message' => 'User Wallet 👍', "data" => $data], 200);
        } catch (\Throwable $th) {
            // throw $th;
            return response()->json([
                'message' => 'This error is from the backend, please contact the backend developer'
            ], 500);
        }
    }
    public function withdraw()
    {
        try {
            if (!auth()->check()) {
                return response()->json(['message' => 'Unauthorized ⚠️'], 401);
            }
            $user = auth()->user();
            $wallet_id = Wallet::find($user->id)->id;

            $wallet = $user->withdrawal()->create([
                "user_id"   => $user->id,
                "wallet_id"   => $wallet_id,
                "amount" => request()->amount,
                "status" => "not-paid",
            ]);
            return response()->json(['message' => 'User Wallet 👍', 'wallet' => $wallet], 200);
        } catch (\Throwable $th) {
            // throw $th;
            return response()->json([
                'message' => 'This error is from the backend, please contact the backend developer'
            ], 500);
        }
    }

    public function updateWithdrawalBank()
    {


        try {
            if (!auth()->check()) {
                return response()->json(['message' => 'Unauthorized ⚠️'], 401);
            }
            $validator = Validator::make(request()->all(), [
                'bank_name' => 'required|string',
                'account_number' => 'required|string',
                'holders_name' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $user = auth()->user();
            $wallet = Wallet::where(['user_id' => $user->id])->first();

            if (!$wallet) {
                return response()->json(['message' => "You cant update your wallet"], 401);
            }

            $wallet->update([
                "bank_name" =>  request()->bank_name,
                "account_number" => request()->account_number,
                "holders_name" => request()->holders_name,
            ]);
            return response()->json(['message' => ' successfully updated User Wallet 👍', 'wallet' => $wallet], 200);
        } catch (\Throwable $th) {
            // throw $th;
            return response()->json([
                'message' => 'This error is from the backend, please contact the backend developer'
            ], 500);
        }
    }
}
