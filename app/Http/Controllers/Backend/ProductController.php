<?php

namespace App\Http\Controllers\Backend;

use Image;
use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use App\Models\MultiImg;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product; 
use Carbon\Carbon;
use DB;

class ProductController extends Controller
{
    public function AllProduct(){

            $product = Product::latest()->get();
            return view('backend.product.product_all',compact('product')); 
    }
    
    public function AddProduct(){

            $brands = Brand::latest()->get();
            $categories = Category::latest()->get();
            $vendors = User::where('status','active')->where('role','vendor')->latest()->get();
            return view('backend.product.product_add',compact('brands','categories','vendors')); 
    }

    public function StoreProduct(Request $request){

            $iamge = $request->file('product_thambnail');
            $name = hexdec(uniqid()).'.'.$iamge->getClientOriginalExtension();
            Image::make($iamge)->resize(800,800)->save('upload/products/thambnail/'.$name);
            $save ='upload/products/thambnail/'.$name;
            $product_id = Product::insertGetId([
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'product_name' => $request->product_name,
                'product_slug' => strtolower(str_replace(' ','-',$request->product_name)),
                'product_code' => $request->product_code,
                'product_qty' => $request->product_qty,
                'product_tags' => $request->product_tags,
                'product_size' => $request->product_size,
                'product_color' => $request->product_color,
                'selling_price' => $request->selling_price,
                'discount_price' => $request->discount_price,
                'short_descp' => $request->short_descp,
                'long_descp' => $request->long_descp,
                'hot_deals' => $request->hot_deals,
                'featured' => $request->featured,
                'special_offer' => $request->special_offer,
                'special_deals' => $request->special_deals,
                'product_thambnail' => $save,
                'vendor_id' => $request->vendor_id,
                'status' => 1,
                'created_at' => Carbon::now(),  
            ]);

            $Mult_iamge = $request->file('multi_img');
            foreach($Mult_iamge as $images) {
            $name_mul = hexdec(uniqid()).'.'.$images->getClientOriginalExtension();
            Image::make($images)->resize(800,800)->save('upload/products/multi-img/'.$name_mul);
            $save_uel ='upload/products/multi-img/'.$name_mul;

            MultiImg::insert([
                'product_id' => $product_id,
                'photo_name' =>$save_uel,
                'created_at' => Carbon::now(),
            ]);
            }
            $notification = array(
                'message' => 'Product Inserted Successfully',
                'alert-type' =>'success',
            );
            return redirect()->route('all.product')->with($notification);

    }

    public function EditeProduct($id){

            $product =Product::findOrFail($id);
            $brands = Brand::latest()->get();
            $categories = Category::latest()->get();
            $subcategory = SubCategory::latest()->get();
            $vendors = User::where('status','active')->where('role','vendor')->latest()->get();
            $Mult_iamge = MultiImg::where('product_id',$id)->get();
            return view('backend.product.product_edit',compact('product','brands','categories','subcategory','vendors','Mult_iamge')); 


    }

    public function UpdateProduct (Request $request) {

            $product_id = $request->id;
            Product::findOrFail($product_id)->update([
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'product_name' => $request->product_name,
                'product_slug' => strtolower(str_replace(' ','-',$request->product_name)),
                'product_code' => $request->product_code,
                'product_qty' => $request->product_qty,
                'product_tags' => $request->product_tags,
                'product_size' => $request->product_size,
                'product_color' => $request->product_color,
                'selling_price' => $request->selling_price,
                'discount_price' => $request->discount_price,
                'short_descp' => $request->short_descp,
                'long_descp' => $request->long_descp,
                'hot_deals' => $request->hot_deals,
                'featured' => $request->featured,
                'special_offer' => $request->special_offer,
                'special_deals' => $request->special_deals,
                'vendor_id' => $request->vendor_id,
                'status' => 1,
                'created_at' => Carbon::now(),  
            ]);
            $notification = array(
                'message' => 'Product Update Without Photo Successfully',
                'alert-type' =>'success',
            );
            return redirect()->route('all.product')->with($notification);
    }

    public function UpdateProductThambnail(Request $request){
             
            $product_id =$request->id;
            $oldImage = $request->old_img;
            $images = $request->file('product_thambnail');
            $name_mul = hexdec(uniqid()).'.'.$images->getClientOriginalExtension();
            Image::make($images)->resize(800,800)->save('upload/products/thambnail/'.$name_mul);
            $save_url = 'upload/products/thambnail/'.$name_mul;
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }
            Product::findOrFail($product_id)->update([
                'product_thambnail' => $save_url,
                'created_at' => Carbon::now(), 
            ]);
            $notification = array(
                'message' => 'Product Thambnail Updated Successfully',
                'alert-type' =>'success',
            );
            return redirect()->back()->with($notification);
            

    }

    public function UpdateProductMultiImage(Request $request){

            $multi_img = $request->multi_img;
            foreach($multi_img as $id => $images) {
                $imgDel =  MultiImg::findOrFail($id);
                unlink($imgDel->photo_name);

                $name_mul = hexdec(uniqid()).'.'.$images->getClientOriginalExtension();
                Image::make($images)->resize(800,800)->save('upload/products/multi-img/'.$name_mul);
                $save_uel ='upload/products/multi-img/'.$name_mul;
                MultiImg::where('id',$id)->update([
                    'photo_name' => $save_uel,
                    'created_at' => Carbon::now(), 
                ]);
                $notification = array(
                    'message' => 'Product Multi Images Updated Successfully',
                    'alert-type' =>'success',
                );
                return redirect()->back()->with($notification);
         }  

    }

    public function DeleteProductMultiImage($id){

        $oldImg = MultiImg::findOrFail($id);
        unlink($oldImg->photo_name);
        MultiImg::findOrFail($id)->delete();
     
        $notification = array(
            'message' => 'Product Multi Images Deleted Successfully',
            'alert-type' =>'success',
        );
        return redirect()->back()->with($notification);

    } 
    
    public function InactiveProduct($id){

        Product::findOrFail($id)->update([ 'status' => 0 ]);
        $notification = array(
            'message' => 'Product Inactive',
            'alert-type' =>'success',
        );
        return redirect()->back()->with($notification);
    }

    public function ActiveProduct($id){
          
        Product::findOrFail($id)->update([ 'status' => 1 ]);
        $notification = array(
            'message' => 'Product Active',
            'alert-type' =>'success',
        );
        return redirect()->back()->with($notification);

    }

    public function DeleteProduct($id){

        $product = Product::findOrFail($id);
        unlink($product->product_thambnail);
        Product::findOrFail($id)->delete();

        $imags =MultiImg::where('product_id', $id)->get();
        foreach($imags as $imag){
            unlink($imag->photo_name);
            MultiImg::where('product_id', $id)->delete();           
        }

        $notification = array(
            'message' => 'Product Deleted successfully',
            'alert-type' =>'success',
        );
        return redirect()->back()->with($notification);
    }

    public function ProductStock(){

        $products = Product::latest()->get();
        return view('backend.product.product_stock',compact('products'));

    }


}