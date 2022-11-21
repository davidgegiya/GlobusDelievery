<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
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
        'name',
        'restaurant_name'
    ];

    protected $casts = [
        'id' => 'string',
    ];

    public function meals(){
        return $this->hasMany(Meal::class);
    }

    public function restaurant(){
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }
}
