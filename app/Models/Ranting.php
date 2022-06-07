<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ranting extends Model
{
    use HasFactory;
      protected $fillable = [
     "rate",
     "user_id",
     "rater_id",
    ];
     public function user()
  {
      return $this->belongsTo(User::class);
  }
}