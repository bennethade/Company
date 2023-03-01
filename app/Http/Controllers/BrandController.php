<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Multipic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Image;
use Nette\Utils\Image;



class BrandController extends Controller
{
    ///TO AUTHENTICATE IF USER IS LOGGED IN 
    ///SO AS TO PROTECT THE REST OF THE PAGE AND REDIRECT TO THE LOGIN PAGE
    public function __construct()
    {
        $this->middleware('auth');
    }
    ///AUTHENTICATION ENDS HERE

    
    public function allBrand()
    {
        $brands = Brand::latest()->paginate(5);
        return view('admin.brand.index',compact('brands'));
    }

    public function storeBrand(Request $request)
    {
        $validated = $request->validate([
            'brand_name' => 'required|unique:brands|min:2',
            'brand_image' => 'required|mimes:png,jpg,jpeg',
        ],

        [
            //TO ECHO YOUR CUSTOMIZED MESSAGE
            'brand_name.required' => 'Please input Brand name',
            'brand_name.unique' => 'Brand name has been taken',
            'brand_name.min' => 'Brand name is too short',
        ]);

        $brand_image = $request->file('brand_image');

        ///SAVING THE IMAGE INTO A LOCATION WITH AN AUTO GENERATED NAME
        $name_generate = hexdec(uniqid());
        $image_extension = strtolower($brand_image->getClientOriginalExtension());
        $img_name = $name_generate.'.'.$image_extension;
        $up_location = 'image/brand/';
        $last_img = $up_location.$img_name;
        $brand_image->move($up_location,$img_name);
        //END SAVING THE IMAGE INTO A LOCATION WITH AN AUTO GENERATED NAME

                ///SAVING IMAGE USING IMAGE INTERVENTION
        // $name_generate = hexdec(uniqid()).'.'.$brand_image->getClientOriginalExtension();
        // Image::make($brand_image)->resize(300,200)->save('image/brand/'.$name_generate);
        
        // $last_img = 'image/brand/'.$name_generate;
                ///END SAVING IMAGE USING IMAGE INTERVENTION

        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_image' => $last_img,
            'created_at' => Carbon::now(),
        ]);

///TO ADD TOASTR NOTIFICATION ON OPERATIONS
        $notification = array(
            'message' => 'Brand inserted successfully!',
            'alert-type' => 'success'
        );
/////TOASTR ENDS HERE
        return redirect()->back()->with($notification); //MAKE SURE TO PASS THE TOASTR VARIABLE

    }


    public function edit($id)
    {
        $brands = Brand::find($id);
        return view('admin.brand.edit', compact('brands'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'brand_name' => 'required|min:2',
        ],

        [
            //TO ECHO YOUR CUSTOMIZED MESSAGE
            'brand_name.required' => 'Please input Brand name',
            'brand_name.min' => 'Brand name is too short',
        ]);

        $old_image = $request->old_image;

        $brand_image = $request->file('brand_image');

        if($brand_image)
        {
            $name_generate = hexdec(uniqid());
            $image_extension = strtolower($brand_image->getClientOriginalExtension());
            $img_name = $name_generate.'.'.$image_extension;
            $up_location = 'image/brand/';
            $last_img = $up_location.$img_name;
            $brand_image->move($up_location,$img_name);
    
            unlink($old_image);
            Brand::find($id)->update([
                'brand_name' => $request->brand_name,
                'brand_image' => $last_img,
                'created_at' => Carbon::now(),
            ]);
    
            $notification = array(
                'message' => 'Brand updated successfully!',
                'alert-type' => 'info'
            );

            return redirect()->back()->with($notification);        
    
        }
        else
        {
            Brand::find($id)->update([
                'brand_name' => $request->brand_name,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Brand updated successfully!',
                'alert-type' => 'warning'
            );
    
            return redirect()->back()->with($notification);        
        }

    }

    public function delete($id)
    {
        //TO DELETE THE IMAGE
        $image = Brand::find($id);
        $old_image = $image->brand_image;
        unlink($old_image);

        //TO DELETE THE BRAND NAME
        Brand::find($id)->delete();

        $notification = array(
            'message' => 'Brand deleted successfully!',
            'alert-type' => 'error'
        );
        return redirect()->back()->with($notification);        
    }


    ////THIS IS FOR MULTI IMAGE METHOD ON BRAND PAGE
    public function multiImage()
    {
        $images = Multipic::all();
        return view('admin.multipic.index',compact('images'));
    }


    ///THIS IS FOR MULTIPLE IMAGE ON MULTI PIC PAGE
    public function storeImage(Request $request)
    {
        $image = $request->file('image');

        ///SAVING THE IMAGE INTO A LOCATION WITH AN AUTO GENERATED NAME
        foreach($image as $multi_img)
        {
            $name_generate = hexdec(uniqid());
            $image_extension = strtolower($multi_img->getClientOriginalExtension());
            $img_name = $name_generate.'.'.$image_extension;
            $up_location = 'image/multi/';
            $last_img = $up_location.$img_name;
            $multi_img->move($up_location,$img_name);
                ////END SAVING THE IMAGE INTO A LOCATION WITH AN AUTO GENERATED NAME

                   ////SAVING IMAGE USING IMAGE INTERVENTION
            // $name_generate = hexdec(uniqid()).'.'.$multi_img->getClientOriginalExtension();
            // Image::make($multi_img)->resize(300,300)->save('image/multi/'.$name_generate);

            // $last_img = 'image/multi/'.$name_generate;
                    ////END SAVING IMAGE USING IMAGE INTERVENTION

            Multipic::insert([
                'image' => $last_img,
                'created_at' => Carbon::now(),
            ]);
    
        }//End of foreach

        return redirect()->back()->with('success','Image inserted successfully!');        
    }


    //FUNCTION FOR LOGOUT
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success','User Logged out');
    }

}

