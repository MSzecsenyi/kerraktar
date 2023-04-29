<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'group_number',
        'district',
        'phone',
        'is_group',
        'is_admin',
        'is_storekeeper'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function stores()
    {
        return $this->belongsToMany(Store::class);
    }

    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    public function takeOuts()
    {
        return $this->hasMany(TakeOut::class);
    }

    public function isStorekeeper()
    {
        return $this->is_storekeeper;
    }

    public function takenOutUniqueItems()
    {
        return $this->hasMany(UniqueItem::class, 'taken_out_by');
    }

    //WEB
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\CustomResetPasswordNotification($token));
    }
}
