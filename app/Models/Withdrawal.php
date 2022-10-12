<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "wallet_id",
        "amount" ,
        "status",
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
