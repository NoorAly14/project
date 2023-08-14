<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
{
    public function AllSubCategory(){

        $subcategoriess = SubCategory::latest()->get();
        return view('backend.subcategory.subcategory_all',compact('subcategoriess'));
    }

    public function AddSubCategory(){

         $categories = Category::orderBy('category_name', 'ASC')->get();
         return view('backend.subcategory.subcategory_add',compact('categories'));
    }
    
    public function StoreSubCategory(Request $request){

        SubCategory::insert([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ','-',$request->subcategory_name)),

        ]);
        $notification = array(
            'message' => 'SubCategory Inserted Successfully',
            'alert-type' =>'success',
        );
        return redirect()->route('all.subcategory')->with($notification);

    }

    public function EditSubCategory($id){

        $categories = Category::orderBy('category_name', 'ASC')->get();
        $subcategory  = SubCategory::findOrFail($id);
        return view('backend.subcategory.subcategory_edit',compact('categories','subcategory'));

    }

    public function UpdateSubCategory(Request $request){

        $subcat = $request->id;
        SubCategory::findOrFail($subcat)->update([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ','-',$request->subcategory_name)),

        ]);
        $notification = array(
            'message' => 'SubCategory Updated Successfully',
            'alert-type' =>'success',
        );
        return redirect()->route('all.subcategory')->with($notification);

    }
    
    public function DeleteSubCategory($id){

        SubCategory::findOrFail($id)->delete();
        $notification = array(
            'message' => 'SubCategory Deleted Successfully',
            'alert-type' =>'success',
        );
        return redirect()->back()->with($notification);

    }

    public function GetSubCategory($category_id){

        $subcat = SubCategory::where('category_id',$category_id)->orderBy('subcategory_name','ASC')->get();
        return json_encode($subcat);
        
    }
    

}
