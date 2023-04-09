<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniqueItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'alt_name',
        'taken_out_by',
    ];

    public $incrementing = false;

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function requests()
    {
        return $this->belongsToMany(Request::class);
    }

    public function takeOuts()
    {
        return $this->belongsToMany(TakeOut::class);
    }

    public function takenOutBy()
    {
        return $this->belongsTo(User::class, 'taken_out_by');
    }
}
