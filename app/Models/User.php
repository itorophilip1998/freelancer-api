<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Skill;
use App\Models\Profile;
use App\Models\Ranting;
// use Laravel\Sanctum\HasApiTokens;
use App\Models\BankDetails;
use App\Models\CardDetails;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
      
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',  
        "password",
        "phone", 
        "address",
        "role", 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];




        /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    } 
    public function card_details()
    {
        return $this->hasMany(CardDetails::class);
    }
    public function profle()
    {
        return $this->hasOne(Profile::class);
    }
    public function ratings(){
        return $this->hasMany(Ranting::class);
    }
    public function skills(){
        return $this->hasMany(Skill::class);
    }
    public function bank_details(){
        return $this->hasMany(BankDetails::class);
    }  
    
}