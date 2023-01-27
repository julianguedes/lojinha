<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'quantity'];
    protected $appends = ['total_products_value'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this
            ->belongsToMany(Product::class, 'cart_product', 'cart_id', 'product_id')
            ->withPivot(['quantity', 'total']);
    }

    public function getTotalProductsValueAttribute()
    {
        $products = $this
            ->products()
            ->get(['value']);
                return array_reduce($products->toArray(), function($total, $product){
                return $total + $product['value'] * $product['pivot']['quantity'];
            }, 0);
    }
}
