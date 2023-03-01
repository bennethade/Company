<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends Controller
{
    public function changePassword()
    {
        return view('admin.body.change_password');
    }

    public function updatePassword(Request $request)
    {
        $validateData = $request->validate([
            'oldpassword' => 'required',
            'password' => 'required|confirmed'
        ]);

        $hashedPassword = Auth::user()->password;
        if(Hash::check($request->oldpassword, $hashedPassword))
        {
            $user = User::find(Auth::id());
            $user->password = Hash::make($request->password);
            $user->save();

            Auth::logout();
            return redirect()->route('login')->with('success','Password changed successfully!');
        }

        else
        {
            return redirect()->back()->with('error','Current password is invalid!');
        }
    }


    //UPDATE PROFILE DETAILS
    public function profileUpdate()
    {
        if(Auth::user())
        {
            $user = User::find(Auth::user()->id);
            if($user)
            {
                return view('admin.body.update_profile',compact('user'));
            }
        }
    }


/// TUTOR'S PROFILE UPDATE FUNCTION

    // public function updateProfile(Request $request)
    // {
    //     $user = User::find(Auth::user()->id);

    //     if($user)
    //     {
    //         $user->name = $request->name;
    //         $user->email = $request->email;

    //         $user->save();
    //         return redirect()->back()->with('success','Profile updated successfully!');
    //     }
    //     else
    //     {
    //         return redirect()->back();
    //     }
    // }

    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $old_image = $request->old_image;

        $profile_photo_path = $request->file('profile_photo_path');
        if($user)
        {
            if($profile_photo_path)
            {
                $name_generate = hexdec(uniqid());
                $image_extension = strtolower($profile_photo_path->getClientOriginalExtension());
                $img_name = $name_generate.'.'.$image_extension;
                $up_location = 'image/profile-photos/';
                $last_img = $up_location.$img_name;
                $profile_photo_path->move($up_location,$img_name);
        
                unlink($old_image);
                // User::find($id)->update([
                User::find(Auth::user()->id)->update([
                    'profile_photo_path' => $last_img,
                    'name' => $request->name,
                    'email' => $request->email,
                    'created_at' => Carbon::now()
                ]);
        
                return redirect()->back()->with('success','Profile updated successfully!');        
    
            }
            else
            {
                User::find(Auth::user()->id)->update([
                // User::find($id)->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'created_at' => Carbon::now()
                ]);
        
                return redirect()->back()->with('success','Brand updated successfully!');        
            }
            // $user->name = $request->name;
            // $user->email = $request->email;
            // $user->profile_photo_path = $request->photo;

            // $user->save();
            // return redirect()->back()->with('success','Profile updated successfully!');
        }
        else
        {
            return redirect()->back();
        }
    }




}
