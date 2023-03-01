<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    ///TO AUTHENTICATE IF USER IS LOGGED IN 
    ///SO AS TO PROTECT THE REST OF THE PAGE AND REDIRECT TO THE LOGIN PAGE
    public function __construct()
    {
        $this->middleware('auth');
    }
    ///AUTHENTICATION ENDS HERE

    public function allCat()
    {
        //ONE TO ONE RELATIONSHIP WITH QUERRY BUILDER
        // $categories = DB::table('categories')
        //     ->join('users','categories.user_id','users.id')
        //     ->select('categories.*','users.name')
        //     ->latest()->paginate(5);

            //ONE TO ONE RELATIONSHIP ENDS FOR QUERRY BUILDER


        $categories = Category::latest()->paginate(5); //FETCHING DATA FROM DB WITH ELOQUENT ORM

        $trashcat = Category::onlyTrashed()->latest()->paginate(3);


        // $categories = DB::table('categories')->latest()->paginate(5);  //USING QUERRY BUILDER PATTERN
        return view('admin.category.index', compact('categories','trashcat')); //MAKE SURE TO PASS THE CATEGORIES VARIABLE IN THE COMPACT SO AS TO USE IT IN THE VIEW FILE
    }

    public function addCat(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|unique:categories|max:255',
            // 'body' => 'required',
        ],

        [
            //TO ECHO YOUR CUSTOMIZED MESSAGE
            'category_name.required' => 'Please input category name',
            'category_name.unique' => 'Category name has been taken',
            'category_name.max' => 'Category name is too long',
        ]);

        //THREE DIFFERENT METHODS OF INSERTING INTO THE DB

        //USING ELOQUENT ORM
        // Category::insert([
        //     'category_name' => $request->category_name,
        //     'user_id' => Auth::user()->id,
        //     'created_at' => Carbon::now()
        // ]);

        //ANOTHER ELOQUENT ORM
        $category = new Category();
        $category->category_name  = $request->category_name;
        $category->user_id  = Auth::user()->id;
        $category->save();


        //USING QUERRY BUILDER METHOD
        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // DB::table('categories')->insert($data);


        return redirect()->back()->with('success','Category inserted successfully!');
    }

    public function edit($id)
    {
        // $categories = Category::find($id);   //EDIT USING ELOQUENT ORM

        $categories = DB::table('categories')->where('id',$id)->first();  //EDIT USING QUERRY BUILDER
        
        return view('admin.category.edit',compact('categories'));
    }

    public function update(Request $request, $id)
    {
        //UPDATE USING ELOQUENT ORM
        // $update = Category::find($id)->update([
        //     'category_name' => $request->category_name,
        //     'user_id' =>Auth::user()->id
        // ]);


        //UPDATE USING QUERRY BUILDER
        $data = array();
        $data['category_name'] = $request->category_name;
        $data['user_id'] = Auth::user()->id;
        DB::table('categories')->where('id',$id)->update($data);


        return redirect()->route('all.category')->with('success','Category updated successfully!');

    }

    public function softDelete($id)
    {
        $delete = Category::find($id)->delete();
        return redirect()->back()->with('success','Category soft deleted successfull!');
    }

    public function restore($id)
    {
        $delete = Category::withTrashed()->find($id)->restore();
        return redirect()->back()->with('success','Category restored successfully!');
    }

    public function remove($id)
    {
        $delete = Category::onlyTrashed()->find($id)->forceDelete();
        return redirect()->back()->with('success','Category permanently deleted!');
    }

}
