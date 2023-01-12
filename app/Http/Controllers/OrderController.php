<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;

class OrderController extends Controller
{

    public function index()
    {
        return Order::all();
    }

    public function store(StoreOrderRequest $request)
    {
        $cart = Cart::with('products')->findOrFail($request->cart_id);
        $order = Order::create(
            [
                'cart_items' => $cart->toArray(),
                'user_id' => $request->user_id
            ]
        );
        $cart->products()->detach();
        return $order;
    }

    public function show(Order $order)
    {
        return $order;
    }

    public function destroy(Order $order)
    {
        $response = $order->delete();
        return response()->json([
            'message' => $response ? 'Ordem de pedido removida!' : 'Ocorreu um erro.',
        ], $response ? 200 : 500);
    }
}
