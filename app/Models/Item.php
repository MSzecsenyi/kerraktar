<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'district',
        'store_id',
        'is_available',
        'is_usable',
        'comment',
        'amount',
        'category_id',
        'item_name',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function requests(){
        return $this->belongsToMany(Request::class);
    }
}
