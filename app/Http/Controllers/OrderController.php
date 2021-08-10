<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request) 
    {
        $product = Product::find($request->product_id);
        if($product->available_stock >= $request->quantity) {            
            $order = new Order;
            $order->product_id = $request->product_id;
            $order->quantity = $request->quantity;
            $order->save();

            $product->available_stock -= $request->quantity;
            $product->save();

            return response()->json(['message' => 'You have successfully ordered this product'], 201);
        } else {
            return response()->json(['message' => 'Failed to order this product due to unavailability of the stock'], 400);
        }
    }
}
