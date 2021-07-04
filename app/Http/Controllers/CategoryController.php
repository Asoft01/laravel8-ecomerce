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
        // $categories = DB::table('categories')
        //             ->join('users', 'categories.user_id', 'users.id')
        //             ->select('categories.*', 'users.name')
        //             ->latest()->paginate(5);

        // $categories = Category::all();
        // $categories = Category::latest()->get();
        $categories = Category::latest()->paginate(5);
        // $categories = DB::table('categories')->latest()->get();
        // $categories = DB::table('categories')->latest()->paginate(5);

        $trashCat = Category::onlyTrashed()->latest()->paginate(3);

        return view('admin.category.index', compact('categories', 'trashCat'));
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

    // Using ORM
    // public function Edit($id){
    //     $categories = Category::find($id);
    //     return view('admin.category.edit', compact('categories'));
    // }

    // public function Update(Request $request, $id){
    //     $update = Category::find($id)->update([
    //         'category_name' => $request->category_name,
    //         'user_id' => Auth::user()->id
    //     ]);
    //     return redirect()->route('all.category')->with('success', 'Category Updated Successfully');
    // }

    // Using Query Builder 
    public function Edit($id){
        $categories = DB::table('categories')->where('id', $id)->first();
        
        return view('admin.category.edit', compact('categories'));
    }

    public function Update(Request $request, $id){
        $data = array();
        $data['category_name'] = $request->category_name;
        $data['user_id'] = Auth::user()->id;
        DB::table('categories')->where('id', $id)->update($data);

        return redirect()->route('all.category')->with('success', 'Category Updated Successfully');
    }

    public function softDelete($id){
        $delete = Category::find($id)->delete();
        return redirect()->back()->with('success', 'Category Soft Deleted Successfully');
    }

    public function Restore($id){
        $delete = Category::withTrashed()->find($id)->restore();
        return redirect()->back()->with('success', 'Category Restored Successfully');
    }

    public function PDelete($id){
        $delete = Category::onlyTrashed()->find($id)->forceDelete();
        return redirect()->back()->with('success', 'Category Permanently Deleted');
    }
}
