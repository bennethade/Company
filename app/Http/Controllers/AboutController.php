<?php

namespace App\Http\Controllers;

use App\Models\HomeAbout;
use App\Models\Multipic;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function homeAbout()
    {
        $homeabout = HomeAbout::latest()->get();
        return view('admin.about.index',compact('homeabout'));
    }

    public function addAbout()
    {
        return view('admin.about.create');
    }

    public function storeAbout(Request $request)
    {
        HomeAbout::insert([
            'title' =>$request->title,
            'short_des' =>$request->short_des,
            'long_des' =>$request->long_des,
            'created_at' => Carbon::now()
        ]);

        return redirect()->route('home.about')->with('success','About inserted successfully!');
    }

    public function editAbout($id)
    {
        $homeabout = HomeAbout::find($id);
        return view('admin.about.edit',compact('homeabout'));
    }

    public function updateAbout(Request $request, $id)
    {
        $update = HomeAbout::find($id)->update([
            'title' =>$request->title,
            'short_des' =>$request->short_des,
            'long_des' =>$request->long_des
        ]);

        return redirect()->route('home.about')->with('success','About updated successfully!');
    }

    public function deleteAbout($id)
    {
        HomeAbout::find($id)->delete();
        return redirect()->back()->with('success','About deleted successfully!');
    }

    public function portfolio()
    {
        $images = Multipic::all();
        return view('pages.portfolio', compact('images'));
    }

}
