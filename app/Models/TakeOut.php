<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TakeOut extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'start_date',
        'end_date',
        'user_id',
        'store_id',
        'take_out_name',
    ];

    public function items()
    {
        return $this->belongsToMany(Item::class)->withPivot('amount')->withTimestamps();
    }

    public function uniqueItems()
    {
        return $this->belongsToMany(UniqueItem::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
