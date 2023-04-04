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
        'in_store_amount',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function requests($startDate = null, $endDate = null, $requestId = null)
    {
        $query = $this->belongsToMany(Request::class)->withPivot('amount');
        if ($startDate && $endDate) {
            $query->where(function($query) use ($startDate, $endDate) {
                $query->where('start_date', '>=', $startDate)
                    ->where('start_date', '<=', $endDate)
                    ->orWhere('end_date', '>=', $startDate)
                    ->where('end_date', '<=', $endDate)
                    ->orWhere(function($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<', $startDate)
                                ->where('end_date', '>', $endDate);
                    });
            });
        }
        if($requestId){
            $query->where('requests.id','!=',$requestId);
        } 
        return $query->get();
    }

    public function takeOuts()
    {
        return $this->belongsToMany(TakeOut::class)->withPivot('amount')->withTimestamps();
    }

    public function uniqueItems()
    {
        return $this->hasMany(UniqueItem::class);
    }
}
