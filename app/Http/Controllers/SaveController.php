<?php

namespace App\Http\Controllers;

use App\Models\Save;
use App\Http\Requests\StoreSaveRequest;
use App\Http\Requests\UpdateSaveRequest;
use App\Models\Profile;
use Illuminate\Support\Facades\Validator;

class SaveController extends Controller
{

    public function add()
    {
        try {
            if (!auth()->check()) {
                return response()->json(['message' => 'Unauthorized ⚠️'], 401);
            }
            request()->validate([
                'saved_user_id' => 'required|integer',
            ]);
            $user_id = auth()->user()["id"];
            if ($user_id == request()->saved_user_id) {
                return response()->json(['message' => 'sorry you cannot save your self ⚠️'], 401);
            }
            $dataExist = Save::where("user_id", $user_id)
                ->where('saved_user_id', request()->saved_user_id)
                ->first();

            if (!$dataExist) {
                $user = Save::create(array_merge(
                    request()->all(),
                    [
                        "user_id" => $user_id
                    ]
                ));
                return response()->json(['message' => 'Successfully Saved user 👍', 'saved_user' => $user], 200);
            }
            $dataExist->delete();
            return response()->json(['message' => 'Successfully Remove Saved User 👍'], 200);
        } catch (\Throwable $th) {
            //   throw $th;
            return response()->json([
                'message' => 'This error is from the backend, please contact the backend developer'
            ], 500);
        }
    }

    public function get($user_id)
    {
        try {
            if (!auth()->check()) {
                return response()->json(['message' => 'Unauthorized ⚠️'], 401);
            }
            $data = Save::where("user_id", $user_id)->with([
                "user.profile",
                "user.profileImage",
                "user.isSaved",
                "user.skills.specialEquipment",
                "user.ratings"
            ])->get();

            $newFormat = $data->map(function ($data) {
                $ranting = $data["user"]["ratings"];
                $arr = $ranting;
                $count = 0;
                $sum = 0;
                $index = 0;
                foreach ($arr as $item) {
                    $count += $item["rate"];
                    $sum += $item["rate"] * ($index += 1);
                }
                if ($count != 0) {
                    $star = $sum / $count;
                    $rate = strlen($star) > 3 ? substr($star, 0, 3)  : $star;
                    $data['rate_star'] = floatval($rate);
                } else {
                    $data['rate_star'] = 0;
                }
                return $data;
            });
            return response()->json(['message' => 'Successfully Loaded  Saved freelancer👍', 'saved' => $newFormat], 200);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json([
                'message' => 'This error is from the backend, please contact the backend developer'
            ], 500);
        }
    }
}
