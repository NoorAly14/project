<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ShipDivision;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;





class CartController extends Controller
{
    public function AddToCart(Request $request,$id){

        if(Session::has('coupon')){ 
            session::forget('coupon');
         }

        $product = Product::findOrFail($id);

        if ($product->discount_price == NULL) {

            Cart::add([
                'id' => $id,
                'name' => $request->product_name,
                'qty' => $request->quantity,
                'price' => $product->selling_price,
                'weight' => 1,
                'options' => [
                    'iamge' => $product->product_thambnail,
                    'color' => $request->color,
                    'size' => $request->size,
                    'vendor' => $request->vendor,
                ],

            ]);
            return response()->json(['success' => 'success Added On Your Cart' ]); 

        } else {
            $dis = $product->selling_price -$product->discount_price;

            Cart::add([
                'id' => $id,
                'name' => $request->product_name,
                'qty' => $request->quantity,
                'price' => $dis ,
                'weight' => 1,
                'options' => [
                    'iamge' => $product->product_thambnail,
                    'color' => $request->color,
                    'size' => $request->size,
                    'vendor' => $request->vendor,
                ],

            ]);
            return response()->json(['success' => 'success Added On Your Cart' ]); 

        }
    }

    public function AddMiniCart(){

                $carts = Cart::content();
                $cartQty = Cart::count();
                $cartTotal = Cart::total();
                return response()->json(array(
                    'carts' => $carts,
                    'cartQty' => $cartQty,
                    'cartTotal' => $cartTotal,
                ));
    }

    public function RemoveMiniCart($rowId){

        Cart::remove($rowId);
        return response()->json(['success' => 'Product Remove From Cart']);
    }

    public function AddToCartDetails(Request $request,$id){

        if(Session::has('coupon')){ 
            session::forget('coupon');
         }

                $product = Product::findOrFail($id);
                if ($product->discount_price == NULL) {
                    Cart::add([
                        'id' => $id,
                        'name' => $request->product_name,
                        'qty' => $request->quantity,
                        'price' => $product->selling_price,
                        'weight' => 1,
                        'options' => [
                            'iamge' => $product->product_thambnail,
                            'color' => $request->color,
                            'size' => $product->product_size,
                            'vendor' => $request->vendor,
                        ],

                    ]);
                    return response()->json(['success' => 'success Added On Your Cart' ]); 

                } else {
                    $dis = $product->selling_price -$product->discount_price;
                    Cart::add([
                        'id' => $id,
                        'name' => $request->product_name,
                        'qty' => $request->quantity,
                        'price' => $dis ,
                        'weight' => 1,
                        'options' => [
                            'iamge' => $product->product_thambnail,
                            'color' => $request->color,
                            'size' => $product->product_size,
                            'vendor' => $request->vendor,
                        ],
                    ]);
                    return response()->json(['success' => 'success Added On Your Cart' ]); 
                }

    }

    public function MyCart(){

        return view('frontend.mycart.view_mycart');
    }

    public function GetCartProduct(){

        $carts = Cart::content();
        $cartQty = Cart::count();
        $cartTotal = Cart::total();
        return response()->json(array(
            'carts' => $carts,
            'cartQty' => $cartQty,
            'cartTotal' => $cartTotal,
        ));

    }

    public function Cartremove($rowId){

        Cart::remove($rowId);
        if(Session::has('coupon')){
            $coupon_name = Session::get('coupon')['coupon_name'];
            $coupon = Coupon::where('coupon_name',$coupon_name)->first();

           Session::put('coupon',[
                'coupon_name' => $coupon->coupon_name, 
                'coupon_discount' => $coupon->coupon_discount, 
                'discount_amount' => round(Cart::total() * $coupon->coupon_discount/100), 
                'total_amount' => round(Cart::total() - Cart::total() * $coupon->coupon_discount/100 )
            ]); 
        }
        return response()->json(['success' => 'Product Remove From Cart']);
    }

    public function CartDecrement($rowId){

        $row = Cart::get($rowId);
        Cart::update($rowId, $row->qty -1);
        if(Session::has('coupon')){
            $coupon_name = Session::get('coupon')['coupon_name'];
            $coupon = Coupon::where('coupon_name',$coupon_name)->first();

           Session::put('coupon',[
                'coupon_name' => $coupon->coupon_name, 
                'coupon_discount' => $coupon->coupon_discount, 
                'discount_amount' => round(Cart::total() * $coupon->coupon_discount/100), 
                'total_amount' => round(Cart::total() - Cart::total() * $coupon->coupon_discount/100 )
            ]); 
        }
    
    
        

        return response()->json('Decrement');
    }

    public function CartIncrement($rowId){

        $row = Cart::get($rowId);
        Cart::update($rowId, $row->qty +1);
        if(Session::has('coupon')){
            $coupon_name = Session::get('coupon')['coupon_name'];
            $coupon = Coupon::where('coupon_name',$coupon_name)->first();

           Session::put('coupon',[
                'coupon_name' => $coupon->coupon_name, 
                'coupon_discount' => $coupon->coupon_discount, 
                'discount_amount' => round(Cart::total() * $coupon->coupon_discount/100), 
                'total_amount' => round(Cart::total() - Cart::total() * $coupon->coupon_discount/100 )
            ]); 
        }
    

        return response()->json('Decrement');
    }

    public function CouponApply(Request $request){

        $coupon = Coupon::where('coupon_name', $request->coupon_name)->where('coupon_validity','>=', Carbon::now()->format('Y-m-d'))->first();
        if($coupon){
            session::put('coupon',[
                'coupon_name' => $coupon->coupon_name, 
                'coupon_discount' => $coupon->coupon_discount, 
                'discount_amount' => round(Cart::total() * $coupon->coupon_discount/100), 
                'total_amount' => round(Cart::total() - Cart::total() * $coupon->coupon_discount/100 )
            ]);

            return response()->json(array(
                'validity' => true,                
                'success' => 'Coupon Applied Successfully'
            ));
            } else{
                return response()->json(['error' => 'Invalid Coupon']);
            }

        }

        public function CouponCalculation(){

            if (Session::has('coupon')){
                return response()->json(array(
                    'subtotal' => Cart::total(),
                    'coupon_name' => session()->get('coupon')['coupon_name'],
                    'coupon_discount' => session()->get('coupon')['coupon_discount'],
                    'discount_amount' => session()->get('coupon')['discount_amount'],
                    'total_amount' => session()->get('coupon')['total_amount'], 
                ));
            }else{
                return response()->json(array(
                    'total' => Cart::total(),
                ));
            }

        }

        public function CouponRemove(){

            Session::forget('coupon');
            return response()->json(['success' => 'Coupon Remove Successfully']);
    
        }

        public function CheckoutCreate(){

            if (Auth::check()){

                if (Cart::total() > 0 ) {

                    $carts = Cart::content();
                    $cartQty = Cart::count();
                    $cartTotal = Cart::total();

                    $division = ShipDivision::orderBy('division_name','ASC')->get();

                    return view('frontend.checkout.checkout_view',compact('carts','cartQty','cartTotal','division'));
                } else { 
                    $notification = array(
                        'message' => 'Shopping At list one product ',
                        'alert-type' =>'error',
                    );
                    return redirect()->to('/')->with($notification); 
                }
            } else{
                $notification = array(
                    'message' => 'You Need to Login First',
                    'alert-type' => 'error'
                );
        
                return redirect()->route('login')->with($notification); 
                }
        
            }
        }
       

    
    

