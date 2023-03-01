<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ServicesController extends Controller
{
    public function homeService()
    {
        $services = Service::latest()->get();
        return view('admin.services.index', compact('services'));
    }

    public function addService()
    {
        return view('admin.services.create');
    }

    public function storeService(Request $request)
    {
        Service::insert([
            'title' => $request->title,
            'description' => $request->description,
            'created_at' => Carbon::now()
        ]);

        return redirect()->route('home.service')->with('success','Service inserted successfully!');
    }

    public function editService($id)
    {
        $homeservice = Service::find($id);
        return view('admin.services.edit', compact('homeservice'));
    }

    public function updateService(Request $request, $id)
    {
        Service::find($id)->update([
            'title' =>$request->title,
            'description' =>$request->description,
        ]);

        return redirect()->route('home.service')->with('success','Service updated successfully!');
    }

    public function deleteService($id)
    {
        Service::find($id)->delete();
        return redirect()->back()->with('success','Service deleted successfully!');
    }


}
