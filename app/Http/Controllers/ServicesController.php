<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
   public function serviceBySkills(){
    $skills=Skill::all();
        $newSkill = [];
        foreach ($skills as $item) {
            $newSkill[] =  $item["name"];
        }
        $newSkill = $newSkill ? array_unique($newSkill) : $newSkill;
        $services=[];
        foreach ($newSkill as $item) {
            $services[] =  [$item,'hello'];
        }
        return $services;
       
   }
}
