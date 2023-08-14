<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\MultiImg;
use App\Models\Brand;
use App\Models\Product;
use App\Models\User; 
use Illuminate\Http\Request;

class IndexController extends Controller
{

   public function Index(){

        $skip_cat = Category::skip(0)->first();
        $skip_product = Product::where('status', 1)->where('category_id',$skip_cat->id)->orderBy('id','DESC')->limit(5)->get();

        $skip_cat_1 = Category::skip(1)->first();
        $skip_product_1 = Product::where('status', 1)->where('category_id',$skip_cat_1->id)->orderBy('id','DESC')->limit(5)->get();

        $skip_cat_2 = Category::skip(2)->first();
        $skip_product_2 = Product::where('status', 1)->where('category_id',$skip_cat_2->id)->orderBy('id','DESC')->limit(5)->get();

        $hot_deals = Product::where('hot_deals', 1)->where('discount_price','!=',NULL)->orderBy('id','DESC')->limit(3)->get();

        $special_offer = Product::where('special_offer', 1)->orderBy('id','DESC')->limit(3)->get();

        $new = Product::where('status',1)->orderBy('id','DESC')->limit(3)->get();

        $special_deals = Product::where('special_deals',1)->orderBy('id','DESC')->limit(3)->get();
        

        return view('frontend.index',compact('skip_cat','skip_product','skip_cat_1','skip_product_1','skip_cat_2','skip_product_2','hot_deals','special_offer','new','special_deals'));
    }
    
   public function ProductDetails($id,$slug){

            $product = Product::findOrFail($id);
            $color =  $product->product_color;
            $product_colors = explode(',', $color);
            $multi = MultiImg::where('product_id',$id)->get();
            $cat_id =$product->category_id;
            $relatedPorduct = Product::where('category_id',$cat_id)->where('id','!=',$id)->limit(4)->get();
            return view('frontend.product.product_details',compact('product','product_colors','multi','relatedPorduct'));

   }

   public function VendorDetails($id){

            $vendor = User::findOrFail($id);
            $vproduct = Product::where('vendor_id',$id)->get();
            return view('frontend.vendor.vendor_details',compact('vendor','vproduct'));

   }

   public function VendorAll(){

            $vendors = User::where('status','active')->where('role','vendor')->orderBy('id','DESC')->get();    
            return view('frontend.vendor.vendor_all',compact('vendors'));        

   }

   public function CatWiseProduct($id,$slug){

            $products = Product::where('status',1)->where('category_id',$id)->orderBy('id','DESC')->get();
            $categories = Category::orderBy('category_name','DESC')->get();
            $cat = Category::where('id',$id)->first();
            $newproduct =  Product::orderBy('id','DESC')->limit(3)->get();
            return view('frontend.product.category_view',compact('products','categories','cat','newproduct'));

   }

   public function SubCatWiseProduct(Request $request,$id,$slug){

            $products = Product::where('status',1)->where('subcategory_id',$id)->orderBy('id','DESC')->get();
            $categories = Category::orderBy('category_name','ASC')->get();
            $breadsubcat  = SubCategory::where('id',$id)->first();
            $newProduct  =  Product::orderBy('id','DESC')->limit(3)->get();
            return view('frontend.product.subcategory_view',compact('products','categories','breadsubcat','newProduct'));

}
public function ProductViewAjax($id){

    $product = Product::with('brand','cat')->findOrFail($id);
    $color = $product->product_color;
    $product_color = explode(',', $color);

    $size = $product->product_size;
    $product_size = explode(',', $size);

    
    return response()->json(array(

     'products' => $product,
     'colors' => $product_color,
     'sizes' => $product_size,
     

    ));

 }// End Method 





   
}