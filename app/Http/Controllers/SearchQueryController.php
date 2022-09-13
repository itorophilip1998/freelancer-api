<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Skill;
use App\Models\Profile;
use App\Models\SpecialEquipment;
use Illuminate\Http\Request;

class SearchQueryController extends Controller
{
    public function query()
    {
        try {


            $skills = $this->searchBySkills(request()["skill"]);
            $location = $this->searchByLocation(request()["location"]);
            $equipment = $this->searchByEquipment(request()["equipment"]);
            // $date = $this->searchByDate(request()["date"]);

            $skill = request()->skill;
            $equipment = request()->equipment;
            $location = request()->location;
            $userBySkill = null;
            // return everything is 
            if ((!$skill || $equipment) && !$location) {
                $userBySkill = User::with(
                    "profile",
                    "skills.specialEquipment",
                    "isSaved",
                    "profileImage",
                    "ratings.user",
                    "gallery"
                )->get();
            }
            // if $
            // else if(){

            // }
            // } else if ( ) {
            //     // $userBySkill = User::whereIn("id", $equipment);
            // } else { 

            // }
            return $userBySkill;

            $userBySkill->map(
                function ($data) {
                    $count = 0;
                    $sum = 0;
                    $index = 0;
                    foreach ($data["ratings"] as $item) {
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
                }
            );

            return  response()->json([
                "message" => "Searched data loaded!",
                "length" => count($userBySkill),
                "data" => $userBySkill
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    //search... by profile
    function searchByLocation($location)
    {

        $profile = Profile::where("city", "$location")
            ->get();
        if (count($profile) <= 0)  return [];
        $profile_user_id = [];
        foreach ($profile as $item) {
            $profile_user_id[] = $item["user_id"];
        }
        return $profile_user_id;
    }

    // search by Skills
    function searchBySkills($skill)
    {
        $skills = Skill::where("name", $skill)
            ->get();
        if (count($skills) <= 0)  return [];
        $skills_user_id = [];
        foreach ($skills as $item) {
            $skills_user_id[] = $item["user_id"];
        }
        return $skills_user_id;
    }
    // search by equipment
    function searchByEquipment($equipment)
    {
        $skills = SpecialEquipment::where("name", $equipment)
            ->get();
        if (count($skills) <= 0)  return [];
        $skills_user_id = [];
        foreach ($skills as $item) {
            $skills_user_id[] = $item["user_id"];
        }
        return $skills_user_id;
    }

    // search by Date
    function searchByDate($date)
    {
        $skills = Skill::where("date", "LIKE", "%$date%")
            ->get();
        if (count($skills) <= 0)  return [];
        $skills_user_id = [];
        foreach ($skills as $item) {
            $skills_user_id[] = $item["user_id"];
        }
        return $skills_user_id;
    }


    public function getUserById($user_id)
    {

        $userBySkill = User::where("id", $user_id)
            ->with(
                "profile",
                "skills.specialEquipment",
                "isSaved",
                "profileImage",
                "ratings.user",
                "gallery",
                "ratings"
            )
            ->get();

        $userBySkill->map(
            function ($data) {
                $count = 0;
                $sum = 0;
                $index = 0;
                foreach ($data["ratings"] as $item) {
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
            }
        );

        return  response()->json([
            "message" => "Searched data loaded!",
            "length" => count($userBySkill),
            "data" => $userBySkill[0]
        ], 200);
    }
}
