<?php

namespace App\Http\Controllers\Backend;

use App\Models\Slider;
use Illuminate\Http\Request;
use Image;
use App\Http\Controllers\Controller;
use PhpParser\Builder\Function_;

class SliderController extends Controller
{
    public function AllSlider(){

        $sliders = Slider::latest()->get();
        return view('backend.slider.slider_all',compact('sliders'));

    }

    public function AddSlider(){

        return view('backend.slider.slider_add');

    }

    public function StoreSlider(Request $request){

        $iamge = $request->file('slider_image');
        $name = hexdec(uniqid()).'.'.$iamge->getClientOriginalExtension();
        Image::make($iamge)->resize(2376,807)->save('upload/slider/'.$name);
        $save ='upload/slider/'.$name;
        Slider::insert([
            'slider_title' => $request->slider_title,
            'short_title' => $request->short_title,
            'slider_image' => $save,
        ]);
        $notification = array(
            'message' => 'Slider Inserted Successfully',
            'alert-type' =>'success',
        );
        return redirect()->route('all.slider')->with($notification);

    }

    public function EditSlider($id){

            $slider = Slider::findOrFail($id);
            return view('backend.slider.slider_edit',compact('slider'));
    }

    public function UpdateSlider(Request $request){

        $slider_id = $request->id;
        $old_img = $request->old_image;
        if ($request->file('slider_image')) {
           $iamge = $request->file('slider_image');
           $name = hexdec(uniqid()).'.'.$iamge->getClientOriginalExtension();
           Image::make($iamge)->resize(2376,807)->save('upload/slider/'.$name);
           $save ='upload/slider/'.$name;

           if (file_exists($old_img)) {
            unlink($old_img);
        }
        Slider::findOrFail($slider_id)->update([
            'slider_title' => $request->slider_title,
            'short_title' => $request->short_title,
            'slider_image' => $save,
        ]);
        $notification = array(
            'message' => 'Slider Updated Successfully',
            'alert-type' =>'success',
        );
        return redirect()->route('all.slider')->with($notification);

     } else {
        Slider::findOrFail($slider_id)->update([
            'slider_title' => $request->slider_title,
            'short_title' => $request->short_title,
            
        ]);
        $notification = array(
            'message' => 'Slider Updated Without Photo Successfully',
            'alert-type' =>'success',
        );
        return redirect()->route('all.slider')->with($notification);

      }  

    }

    public Function DeleteSlider($id){

        $slider_id = Slider::findOrFail($id);
        $img = $slider_id->slider_image;
        unlink($img);
        Slider::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Slider Deleted Successfully',
            'alert-type' =>'success',
        );
        return redirect()->back()->with($notification);

    }
}