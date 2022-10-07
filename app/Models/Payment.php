<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        "amount",
        "status",
        "booked_user_id",
        "user_id",
        'payment_id'

    ];
}
