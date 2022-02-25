<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

        protected $fillable = [
        'start_date',
        'end_date',
        'user_id'
    ];

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
