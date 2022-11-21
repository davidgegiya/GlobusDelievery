<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'restaurant_id',
        'category_id',
        'price',
        'name',
        'image',
        'restaurant_name',
        'category_name'
    ];

    protected $casts = [
        'id' => 'string',
    ];

    public function order_items(){
        return $this->hasMany(OrderItem::class);
    }

    public function restaurant(){
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
}
