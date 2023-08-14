<?php

namespace App\Http\Controllers\Backend;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;

class BannerController extends Controller
{
    public function AllBanner(){

        $banner = Banner::latest()->get();
        return view('backend.banner.banner_all',compact('banner'));
    }

    public function AddBanner(){

        return view('backend.banner.banner_add');
    }

    public function StoreBanner(Request $request){

        $iamge = $request->file('banner_image');
        $name = hexdec(uniqid()).'.'.$iamge->getClientOriginalExtension();
        Image::make($iamge)->resize(768,450)->save('upload/banner/'.$name);
        $save ='upload/banner/'.$name;
        Banner::insert([
            'banner_title' => $request->banner_title,
            'banner_url' => $request->banner_url,
            'banner_image' => $save,
        ]);
        $notification = array(
            'message' => 'Banner Inserted Successfully',
            'alert-type' =>'success',
        );
        return redirect()->route('all.banner')->with($notification);
    }

    public function EditeBanner($id){

        $banner = Banner::findOrFail($id);
        return view('backend.banner.banner_edit',compact('banner'));

    }

    public function UpdateBanner(Request $request){

        $slider_id = $request->id;
        $old_img = $request->old_image;
        if ($request->file('banner_image')) {
           $iamge = $request->file('banner_image');
           $name = hexdec(uniqid()).'.'.$iamge->getClientOriginalExtension();
           Image::make($iamge)->resize(768,450)->save('upload/banner/'.$name);
           $save ='upload/banner/'.$name;

           if (file_exists($old_img)) {
            unlink($old_img);
        }
        Banner::findOrFail($slider_id)->update([
            'banner_title' => $request->banner_title,
            'banner_url' => $request->banner_url,
            'banner_image' => $save,
        ]);
        $notification = array(
            'message' => 'Banner Updated Successfully',
            'alert-type' =>'success',
        );
        return redirect()->route('all.banner')->with($notification);

     } else {
        Banner::findOrFail($slider_id)->update([
            'banner_title' => $request->banner_title,
            'banner_url' => $request->banner_url,
            
        ]);
        $notification = array(
            'message' => 'Banner Updated Without Photo Successfully',
            'alert-type' =>'success',
        );
        return redirect()->route('all.banner')->with($notification);
        }

    } 

    public function DeleteBanner($id){

        $banner_id = Banner::findOrFail($id);
        $img = $banner_id->banner_image;
        unlink($img);
        Banner::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Banner Deleted Successfully',
            'alert-type' =>'success',
        );
        return redirect()->back()->with($notification);

    }
    
}