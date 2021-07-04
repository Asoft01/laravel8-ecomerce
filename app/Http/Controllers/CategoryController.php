<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function AllCat(){
        // $categories = Category::all();
        // $categories = Category::latest()->get();
        $categories = Category::latest()->paginate(5);
        // $categories = DB::table('categories')->latest()->get();
        // $categories = DB::table('categories')->latest()->paginate(5);
        return view('admin.category.index', compact('categories'));
    }

    public function AddCat(Request $request){
        $validatedData = $request->validate([
            'category_name' => 'required|unique:categories|max:255',
        ],
        [
            'category_name.required'=> 'Please Input Category Name',
            'category_name.max'=> 'Category less than 255 characters',
        ]);

        // First Method

        Category::insert([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now()
        ]);

        // This is the second method and more professional format
        // $category = new Category;
        // $category->category_name = $request->category_name;
        // $category->user_id = Auth::user()->id;
        // $category->save();
        
        // Third Method
        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // DB::table('categories')->insert($data);

        return redirect()->back()->with('success', 'Category Inserted Successfully');
    }
}
