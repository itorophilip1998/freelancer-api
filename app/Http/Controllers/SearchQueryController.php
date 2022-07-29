<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Skill;
use App\Models\Profile;
use Illuminate\Http\Request;

class SearchQueryController extends Controller
{
    public function query()
    {
        try {

            if (!request()["skill"]) {

                return response()->json(["message" => "please add a skill!"], 404);
            }

            $skills = $this->searchBySkills(request()["skill"]);
            $location = $this->searchByLocation(request()["location"]);
            // $date = $this->searchByDate(request()["date"]);

            $userBySkill = User::whereIn("id", $skills)
                ->orWhereIn("id", $location)
                ->with("profile", "skills.specialEquipment", "isSaved", "profileImage", "ratings", "gallery")
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
                "message" => "Searched data loaded!", "data" => $userBySkill
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    //search... by profile
    function searchByLocation($location)
    {
        $profile = Profile::where("city", $location)->get();
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
}
