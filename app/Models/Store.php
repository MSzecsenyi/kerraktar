<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'district',
        'address',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    public function takeouts()
    {
        return $this->hasMany(TakeOut::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
