<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $appends = ['total_value'];


    protected $fillable = ['name', 'description', 'value'];

    public function carts()
    {
        return $this->belongsToMany(Cart::class);
    }

    public function getTotalValueAttribute()
    {
        return $this->value * ($this->pivot->quantity ?? 0);
    }

}
