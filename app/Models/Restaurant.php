<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Restaurant extends Model
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
        'name',
        'image',
        'delivery_price',
        'delivery_time',
        'rating'
    ];

    protected $casts = [
        'id' => 'string',
    ];

    public function meals(){
        return $this->hasMany(Meal::class);
    }

    public function categories(){
        return $this->hasMany(Category::class);
    }
}
