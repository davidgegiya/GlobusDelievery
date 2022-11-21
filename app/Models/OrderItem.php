<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'order_id',
        'user_id',
        'meal_id',
        'count'
    ];

    protected $casts = [
        'id' => 'string',
    ];

    public function meal(){
        return $this->belongsTo(Meal::class, 'meal_id');
    }

    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }
}
