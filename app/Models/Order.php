<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
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
        'user_id',
        'total_price',
        'delivery_time'
    ];

    protected $casts = [
        'id' => 'string',
    ];

    public function order_items(){
        return $this->hasMany(OrderItem::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
