<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Http\Requests\Cart\AddProductRequest;
use App\Http\Requests\Cart\RemoveProductRequest;


class CartController extends Controller
{

    public function index()
    {
        return Cart::all();
    }

    public function show(Cart $cart)
    {
        return $cart->loadMissing('products');
    }

    public function addProduct(Cart $cart, AddProductRequest $request){
        $product = $cart->products()->find($request->product_id);
        if($product)

        {
          $cart->products()->updateExistingPivot($request->product_id, [
            'quantity' => $product->pivot->quantity + $request->quantity,
            'total' => ($product->pivot->quantity + $request->quantity) * $product->value
        ]);
        }
        
        else
        {
            $cart->products()->attach($request->product_id, [
                'quantity' => $request->quantity,
                'total' => Product::find($request->product_id)->value * $request->quantity
            ]);
        }
        return $cart;
    }

    public function removeProduct(Cart $cart, RemoveProductRequest $request)
    {
       $product = $cart->products()->findOrFail($request->product_id);
        abort_if($product->pivot->quantity < $request->quantity, 500, 'Impossível remover essa quantidade');

        if($product->pivot->quantity > $request->quantity)
        {
            $cart->products()->updateExistingPivot($request->product_id, [
                'quantity' => $product->pivot->quantity - $request->quantity,
                'total' => ($product->pivot->quantity - $request->quantity) * $product->value
            ]);
        }
        else
        {
            $cart->products()->detach($request->product_id);
        }
        return $cart;
    }

    public function removeAllProducts(Cart $cart)
    {
        $cart->products()->detach();
        return ['message' => 'Todos os itens foram removidos.'];
    }

}
