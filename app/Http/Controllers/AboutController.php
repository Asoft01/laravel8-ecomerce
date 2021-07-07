<?php

namespace App\Http\Controllers;

use App\Models\HomeAbout;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function HomeAbout(){
        $homeabout = HomeAbout::latest()->get();
        return view('admin.home.index', compact('homeabout'));
    }

    public function AddAbout(){
        return view('admin.home.create');
    }

    public function StoreAbout(Request $request){
        // ORM
        HomeAbout::insert([
            'title' => $request->title,
            'short_dis'=> $request->short_dis,
            'long_dis'=> $request->long_dis,
            'created_at' => Carbon::now()
        ]);

        return redirect()->route('home.about')->with('success', 'About Inserted Successfully');
    }

    public function EditAbout($id){
        // ORM 
        $homeabout = HomeAbout::find($id);
        return view('admin.home.edit', compact('homeabout'));
    }

    public function UpdateAbout(Request $request, $id){
        $update = HomeAbout::find($id)->update([
            'title' => $request->title,
            'short_dis'=> $request->short_dis,
            'long_dis'=> $request->long_dis,
        ]);

        return redirect()->route('home.about')->with('success', 'About Updated Successfully');
    }

    public function DeleteAbout($id){
        $delete = HomeAbout::find($id)->delete();
        return redirect()->back()->with('success', 'About Deleted Successfully');
    }
}
