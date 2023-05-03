<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UniqueItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'alt_name',
        'taken_out_by',
        'uuid',
    ];

    public $incrementing = false;

    public function item()
    {
        return $this->belongsTo(Item::class);
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
