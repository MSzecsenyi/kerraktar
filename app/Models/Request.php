<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    public function item()
    {
        return $this->belongsToMany(Item::class);
    }

    public function group()
    {
        return $this->belongsToMany(Group::class);
    }
}
