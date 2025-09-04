<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Auth;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_name',
        'user_type',
        'email',
        'password',
        'first_name',
        'last_name',
        'gender',
        'dob',
        'country_id',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'photo',
        'is_notification',
        'status',
        'device_type',
        'device_token',
        'stripe_customer_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(UserSubscription::class)->where('status', 'active');
    }

    public function stripePayments()
    {
        return $this->hasMany(StripePayment::class);
    }

    public function hasActiveSubscription()
    {
        return $this->activeSubscription()->exists();
    }



    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }
    

    public function getPhotoAttribute($value)
    {
        if ($value) {
            return asset('/user/' . $value);
        } else {
            return null;
        }
    }
}
