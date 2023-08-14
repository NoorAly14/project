<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class WishlistController extends Controller
{
    public function AddToWishlist(Request $request,$product_id){

                if(Auth::check()){

                $exisits = Wishlist::where('user_id',Auth::id())->where('product_id',$product_id)->first();
                if(!$exisits) {
                    Wishlist::insert([
                        'user_id' => Auth::id(),
                        'product_id' => $product_id,
                        'created_at' =>  Carbon::now(),
                    ]);
                    return response()->json(['success' => 'Successfully Added On Your Wishlist' ]);
                }else {
                    return response()->json(['error' => 'This Product Has Already on Your Wishlist' ]);
                } 
                }else { 
                    return response()->json(['error' => 'At First Login Your Account' ]);
                }
    }

    public function AllWishlist(){

        
        return view('frontend.wishlist.view_wishlist');

    }

    public function GetWishlistProduct(){

        $wishlist = Wishlist::with('product')->where('user_id',Auth::id())->latest()->get();

        $wishQty = wishlist::where('user_id',Auth::id())->count(); 

        return response()->json(['wishlist'=> $wishlist, 'wishQty' => $wishQty]);

    }

    public function WishlistRemove($id){

        Wishlist::where('user_id',Auth::id())->where('id',$id)->delete();
        return response()->json(['success' => 'Successfully Product Remove' ]);
    }

  } 


