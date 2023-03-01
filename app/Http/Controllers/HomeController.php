<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;

class HomeController extends Controller
{
    public function homeSlider()
    {
        $sliders = Slider::latest()->get();
        return view('admin.slider.index',compact('sliders'));
    }

    public function addSlider()
    {
        return view('admin.slider.create');
    }

    public function storeSlider(Request $request)
    {
        $slider_image = $request->file('image');

        ///SAVING THE IMAGE INTO A LOCATION WITH AN AUTO GENERATED NAME
        $name_generate = hexdec(uniqid());
        $image_extension = strtolower($slider_image->getClientOriginalExtension());
        $img_name = $name_generate.'.'.$image_extension;
        $up_location = 'image/slider/';
        $last_img = $up_location.$img_name;
        $slider_image->move($up_location,$img_name);
        //END SAVING THE IMAGE INTO A LOCATION WITH AN AUTO GENERATED NAME

                ///SAVING IMAGE USING IMAGE INTERVENTION
        // $name_generate = hexdec(uniqid()).'.'.$slider_image->getClientOriginalExtension();
        // Image::make($slider_image)->resize(1920,1088)->save('image/slider/'.$name_generate);
        
        // $last_img = 'image/slider/'.$name_generate;
                ///END SAVING IMAGE USING IMAGE INTERVENTION

        Slider::insert([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $last_img,
            'created_at' => Carbon::now(),
        ]);

        return Redirect()->route('home.slider')->with('success','Slider inserted successfully!');

    }

    public function edit($id)
    {
        $sliders = Slider::find($id);
        return view('admin.slider.edit',compact('sliders'));
    }

    public function update(Request $request, $id)
    {
        $old_image = $request->old_image;

        $image = $request->file('image');

        if($image)
        {
            $name_generate = hexdec(uniqid());
            $image_extension = strtolower($image->getClientOriginalExtension());
            $img_name = $name_generate.'.'.$image_extension;
            $up_location = 'image/slider/';
            $last_img = $up_location.$img_name;
            $image->move($up_location,$img_name);
    
            unlink($old_image);
            Slider::find($id)->update([
                'title' => $request->title,
                'image' => $last_img,
                'created_at' => Carbon::now(),
            ]);
    
            return redirect()->route('home.slider')->with('success','Slider updated successfully!');        
    
        }
        else
        {
            Slider::find($id)->update([
                'title' => $request->title,
                'created_at' => Carbon::now(),
            ]);
    
            return redirect()->route('home.slider')->with('success','Slider updated successfully!');        
        }

    }


    public function delete($id)
    {
        //TO DELETE THE IMAGE
        $image = Slider::find($id);
        $old_image = $image->image;
        unlink($old_image);

        //TO DELETE THE BRAND NAME
        Slider::find($id)->delete();
        return redirect()->back()->with('success','Slider deleted successfully!');        
    }



    
}
