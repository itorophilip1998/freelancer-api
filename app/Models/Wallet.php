<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory;
    protected $fillable=[
        "user_id", 
        "total_balance",
        "balance", 
        "bank_name", 
        "account_number", 
        "holders_name"
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}