<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
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


Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', function () {
    echo " This is Home page ";
});

Route::get('/about', function(){
    return view('about');
});

// Route::get('/about', function () {
//     return view('about');
// })->middleware('check');


// Route::get('/contact', function () {
//     return view('contact');
// });

// Route::get('/contact', [ContactController::class, 'index']);
Route::get('/contact-sdbjksd-sdhbh', [ContactController::class, 'index'])->name('ariyan');

// Category Controller
Route::get('/category/all', [CategoryController::class, 'AllCat'])->name('all.category');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    // $users = User::all();

    // Using Query Builder
    $users= DB::table('users')->get();

    return view('dashboard', compact('users'));
})->name('dashboard');
