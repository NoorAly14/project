<?php

namespace App\Http\Controllers\Backend;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;

class BrandController extends Controller
{
    public function AllBrand(){

       $brands = Brand::latest()->get();
       return view('backend.brand.brand_all',compact('brands'));
    }

    public function AddBrand(){

        return view('backend.brand.brand_add');
    }

    public function StoreBrand(Request $request){
        
        $iamge = $request->file('brand_image');
        $name = hexdec(uniqid()).'.'.$iamge->getClientOriginalName();
        Image::make($iamge)->resize(300,300)->save('upload/brand/'.$name);
        $save ='upload/brand/'.$name;
        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_slug' => strtolower(str_replace(' ','-',$request->brand_name)),
            'brand_image' => $save,
        ]);
        $notification = array(
            'message' => 'Brand Inserted Successfully',
            'alert-type' =>'success',
        );
        return redirect()->route('all.brand')->with($notification);

    }

    public function EditBrand($id){

        $brand = Brand::findOrFail($id);
        return view('backend.brand.brand_edit',compact('brand'));
    }

    public function UpdateBrand(Request $request){

        $brand_id = $request->id;
        $old_img = $request->old_image;
        if ($request->file('brand_image')) {
           $iamge = $request->file('brand_image');
           $name = hexdec(uniqid()).'.'.$iamge->getClientOriginalName();
           Image::make($iamge)->resize(300,300)->save('upload/brand/'.$name);
           $save ='upload/brand/'.$name;

           if (file_exists($old_img)) {
            unlink($old_img);
        }
        Brand::findOrFail($brand_id)->update([
            'brand_name' => $request->brand_name,
            'brand_slug' => strtolower(str_replace(' ','-',$request->brand_name)),
            'brand_image' => $save,
        ]);
        $notification = array(
            'message' => 'Brand Updated Successfully',
            'alert-type' =>'success',
        );
        return redirect()->route('all.brand')->with($notification);

     } else {
        Brand::findOrFail($brand_id)->update([
            'brand_name' => $request->brand_name,
            'brand_slug' => strtolower(str_replace(' ','-',$request->brand_name)),
            
        ]);
        $notification = array(
            'message' => 'Brand Updated Without Photo Successfully',
            'alert-type' =>'success',
        );
        return redirect()->route('all.brand')->with($notification);
     }

    }

    public function DeleteBrand($id){

        $brand = Brand::findOrFail($id);
        $img = $brand->brand_image;
        unlink($img);
        Brand::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Brand Deleted Successfully',
            'alert-type' =>'success',
        );
        return redirect()->back()->with($notification);
 
    }



}