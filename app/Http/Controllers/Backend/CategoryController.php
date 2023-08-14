<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Image;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    public function AllCategory(){

        $categories = Category::latest()->get();
        return view('backend.category.category_all',compact('categories'));
    }

    public function AddCategory(){

        return view('backend.category.category_add');
    }

    

    public function StoreCategory(Request $request){
    
            $iamge = $request->file('category_image');
            $name = hexdec(uniqid()).'.'.$iamge->getClientOriginalName();
            Image::make($iamge)->resize(300,300)->save('upload/category/'.$name);
            $save ='upload/category/'.$name;
            Category::insert([
                'category_name' => $request->category_name,
                'category_slug' => strtolower(str_replace(' ','-',$request->category_name)),
                'category_image' => $save,
            ]);
            $notification = array(
                'message' => 'Category Inserted Successfully',
                'alert-type' =>'success',
            );
            return redirect()->route('all.category')->with($notification);

    }

    public function EditCategory($id){

        $category = Category::findOrFail($id);
        return view('backend.category.category_edit',compact('category'));
    }

    public function UpdateCategory(Request $request){

        $category_id = $request->id;
        $old_img = $request->old_image;
        if ($request->file('category_image')) {
           $iamge = $request->file('category_image');
           $name = hexdec(uniqid()).'.'.$iamge->getClientOriginalName();
           Image::make($iamge)->resize(300,300)->save('upload/category/'.$name);
           $save ='upload/category/'.$name;

           if (file_exists($old_img)) {
            unlink($old_img);
        }
        Category::findOrFail($category_id)->update([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ','-',$request->category_name)),
            'category_image' => $save,
        ]);
        $notification = array(
            'message' => 'Category Updated Successfully',
            'alert-type' =>'success',
        );
        return redirect()->route('all.category')->with($notification);

     } else {
        Category::findOrFail($category_id)->update([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ', '-',$request->category_name)), 
            
        ]);
        $notification = array(
            'message' => 'Category Updated Without Photo Successfully',
            'alert-type' =>'success',
        );
        return redirect()->route('all.category')->with($notification);
     }  
    }

     public function DeleteCategory($id){

        $category = Category::findOrFail($id);
        $img = $category->category_image;
        unlink($img);
        Category::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Category Deleted Successfully',
            'alert-type' =>'success',
        );
        return redirect()->back()->with($notification);
     }
}

