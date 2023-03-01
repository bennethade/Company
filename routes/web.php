<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServicesController;
use App\Models\Multipic;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/', function () {
    $brands = DB::table('brands')->get();
    $abouts = DB::table('home_abouts')->first();
    $services = DB::table('services')->get();
    $images = Multipic::all();
    return view('home',compact('brands','abouts','services','images'));   ///MAKE SURE YOU PASS THE VARIABLES USING COMPACT
});

Route::get('/about', function () {
    return view('about'); 
});

// Route::get('/contact', function () {
//     return view('contact'); 
// });

Route::get('/contact', [ContactController::class,'render'])->name('contact');

//Category Controller
Route::get('/category/all', [CategoryController::class,'allCat'])->name('all.category');
Route::post('/category/add', [CategoryController::class,'addCat'])->name('store.category');
Route::get('/category/edit/{id}', [CategoryController::class,'edit']);
Route::post('/category/update/{id}', [CategoryController::class,'update']);
Route::get('/softdelete/category/{id}', [CategoryController::class,'softDelete']);
Route::get('/category/restore/{id}', [CategoryController::class,'restore']);
Route::get('/category/remove/{id}', [CategoryController::class,'remove']);


//BRAND CONTROLLER
Route::get('/brand/all', [BrandController::class,'allBrand'])->name('all.brand');
Route::post('/brand/add', [BrandController::class,'storeBrand'])->name('store.brand');
Route::get('/brand/edit/{id}', [BrandController::class,'edit']);
Route::post('/brand/update/{id}', [BrandController::class,'update']);
Route::get('/brand/delete/{id}', [BrandController::class,'delete']);



//MULTI IMAGE ROUTE
Route::get('/multi/image', [BrandController::class,'multiImage'])->name('multi.image');
Route::post('/multi/add', [BrandController::class,'storeImage'])->name('store.image');




///ADMIN ALL ROUTE
Route::get('/home/slider', [HomeController::class,'homeSlider'])->name('home.slider');
Route::get('/add/slider', [HomeController::class,'addSlider'])->name('add.slider');
Route::post('/store/slider', [HomeController::class,'storeSlider'])->name('store.slider');
Route::get('/slider/edit/{id}', [HomeController::class,'edit']);
Route::post('/slider/update/{id}', [HomeController::class,'update']);
Route::get('/slider/delete/{id}', [HomeController::class,'delete']);


//HOME ABOUT ALL ROUTE
Route::get('/home/about',[AboutController::class,'homeAbout'])->name('home.about');
Route::get('/add/about',[AboutController::class,'addAbout'])->name('add.about');
Route::post('/store/about',[AboutController::class,'storeAbout'])->name('store.about');
Route::get('about/edit/{id}',[AboutController::class,'editAbout']);
Route::post('update/homeabout/{id}',[AboutController::class,'updateAbout']);
Route::get('about/delete/{id}',[AboutController::class,'deleteAbout']);



//HOME SERVICE ALL ROUTE
Route::get('/home/service',[ServicesController::class,'homeService'])->name('home.service');
Route::get('/add/service',[ServicesController::class,'addService'])->name('add.service');
Route::post('/store/service',[ServicesController::class,'storeService'])->name('store.service');
Route::get('service/edit/{id}',[ServicesController::class,'editService']);
Route::post('update/homeservice/{id}',[ServicesController::class,'updateService']);
Route::get('service/delete/{id}',[ServicesController::class,'deleteService']);




//PORTFOLIO ALL ROUTE
Route::get('/portfolio',[AboutController::class,'portfolio'])->name('portfolio');



//ADMIN CONTACT PAGE ROUTE
Route::get('/admin/contact',[ContactController::class,'adminContact'])->name('admin.contact');
Route::get('/admin/add/contact',[ContactController::class,'adminAddContact'])->name('add.contact');
Route::post('/admin/store/contact',[ContactController::class,'adminStoreContact'])->name('store.contact');
Route::get('contact/edit/{id}',[ContactController::class,'editContact']);
Route::post('update/contact/{id}',[ContactController::class,'updateContact']);
Route::get('contact/delete/{id}',[ContactController::class,'deleteContact']);
Route::get('admin/message',[ContactController::class,'adminMessage'])->name('admin.message');
Route::get('message/delete/{id}',[ContactController::class,'adminDeleteMessage']);







//HOME CONTACT PAGE ROUTE
Route::get('/contact',[ContactController::class,'contact'])->name('contact');
Route::post('contact/form',[ContactController::class,'contactForm'])->name('contact.form');





Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified'])->group(function () {
    Route::get('/dashboard', function () {
        
        // $users = User::all();
        // $users = DB::table('users')->get();

        return view('admin.index',);
})->name('dashboard');
});

Route::get('/user/logout', [BrandController::class,'logout'])->name('user.logout');


///CHANGE PASSWORD AND USER PROFILE ROUTE
Route::get('/user/password',[ChangePassword::class,'changePassword'])->name('change.password');
Route::post('/password/update',[ChangePassword::class,'updatePassword'])->name('password.update');



///USER PROFILE
Route::get('/user/profile',[ChangePassword::class,'profileUpdate'])->name('profile.update');
Route::post('/user/profile/update',[ChangePassword::class,'updateProfile'])->name('update.user.profile');


