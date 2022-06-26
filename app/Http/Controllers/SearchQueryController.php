<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Skill;
use App\Models\Profile;
use Illuminate\Http\Request;

class SearchQueryController extends Controller
{
    public function query(){
     
        $skills=$this->searchBySkills(request());
        $location=$this->searchByLocation(request()["location"]);
 
        $userBySkill=User::whereIn("id",$skills)
         ->orWhereIn("id",$location )
        ->with("profile","skills")
        ->get();
        return $userBySkill;
    }

        //search... by profile
    function searchByLocation($location){
     $profile=Profile::where("location","LIKE","%$location%")->get();
     if(count($profile) <=0)  return [];
        $profile_user_id=[];
        foreach ($profile as $item) {
          $profile_user_id[]= $item["user_id"]; 
        } 
    return $profile_user_id;
    }
     
    function searchBySkills($req){ 
     $skills=Skill::where("name","LIKE","%$req->skill%") 
     ->get();
     if(count($skills) <=0)  return [];
         $skills_user_id=[];
        foreach ($skills as $item) {
          $skills_user_id[]= $item["user_id"]; 
        } 
    return $skills_user_id;
    }
}