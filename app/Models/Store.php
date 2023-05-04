<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'district',
        'address',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function uniqueItems()
    {
        return $this->hasMany(UniqueItem::class);
    }

    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    public function takeOuts()
    {
        return $this->hasMany(TakeOut::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
