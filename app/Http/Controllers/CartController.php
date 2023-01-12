<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\AddProductRequest;
use App\Http\Requests\RemoveProductRequest;


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

    public function addProduct(Cart $cart, Request $request)
    {
        $product = $cart->products()->find($request->product_id);
        if($product)
        {
          $cart->products()->updateExistingPivot($request->product_id, ['quantity' => $product->pivot->quantity + $request->quantity]);
        }
        else
        {
          $cart->products()->attach($request->product_id, ['quantity' => $request->quantity]);
        }
        return $cart;
    }

    public function removeProduct(Cart $cart, Request $request)
    {
       $product = $cart->products()->find($request->product_id);
        abort_if($product->pivot->quantity < $request->quantity, 500, 'Impossível remover essa quantidade');

        if($product->pivot->quantity > $request->quantity)
        {
            $cart->products()->updateExistingPivot($request->product_id, ['quantity' => $product->pivot->quantity - $request->quantity]);
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
