<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem; 
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class CashController extends Controller
{
    public function CashOrder(Request $request){

        if(Session::has('coupon')){
                $total_amount = Session::get('coupon')['total_amount'];
            }else{
                $total_amount = round(Cart::total());
            }

        
 
            $order_id = Order::insertGetId([
                'user_id' => Auth::id(),
                'division_id' => $request->division_id,
                'district_id' => $request->district_id,
                'state_id' => $request->state_id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'adress' => $request->address,
                'post_code' => $request->post_code,
                'notes' => $request->notes,
    
                'payment_type' => 'Cash On Delivery',
                'payment_method' => 'Cash On Delivery',
    
                'currency' => 'Usd',
                'amount' => $total_amount,
    
    
                'invoice_no' => 'EOS'.mt_rand(10000000,99999999),
                'order_date' => Carbon::now()->format('d F Y'),
                'order_month' => Carbon::now()->format('F'),
                'order_year' => Carbon::now()->format('Y'), 
                'status' => 'pending',
                'created_at' => Carbon::now(),  
    
            ]);
            


    $carts = Cart::content();
    foreach($carts as $cart){

        OrderItem::insert([
            'order_id' => $order_id,
            'product_id' => $cart->id,
            'vendor_id' => $cart->options->vendor,
            'color' => $cart->options->color,
            'size' => $cart->options->size,
            'qty' => $cart->qty,
            'price' => $cart->price,
            'created_at' =>Carbon::now(),

        ]);

    } // End Foreach

    if (Session::has('coupon')) {
       Session::forget('coupon');
    }

    Cart::destroy();

    $notification = array(
        'message' => 'Your Order Place Successfully',
        'alert-type' => 'success'
    );

    return redirect()->route('UserDashboard')->with($notification); 

        

          
    }

      
}

