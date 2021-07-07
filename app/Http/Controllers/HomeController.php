<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Image;

class HomeController extends Controller
{
    public function HomeSlider(){
        $sliders = Slider::latest()->get();
        return view('admin.slider.index', compact('sliders'));
    }

    public function AddSlider(){
        return view('admin.slider.create');
    }

    public function StoreSlider(Request $request){
        $slider_image = $request->file('image');

        $name_gen = hexdec(uniqid()).'.'.$slider_image->getClientOriginalExtension();
        Image::make($slider_image)->resize(1920, 1088)->save('image/slider/'.$name_gen);

        $last_img = 'image/slider/'.$name_gen;

        // Eloquent ORM
        Slider::insert([
            'title'=> $request->title,
            'description'=> $request->description,
            'image' => $last_img,
            'created_at' => Carbon::now()
        ]);
        
        return redirect()->route('home.slider')->with('success', 'Slider Inserted Successfully');
    }

    public function Edit($id){
        $slider = Slider::find($id);
        return view('admin.slider.edit', compact('slider'));
    }

    public function UpdateSlider(Request $request, $id){

        
        // dd($request); die;
        
        $validatedData = $request->validate([
            'title' => 'required|min:4',
            'description' => 'required|min:20',
        ],
        [
            'title.required'=> 'Please Input Title',
            'description.required'=> 'Please Input Slider Description',
            'image.min'=> 'Brand Longer than 4 Characters',
        ]);

        $old_image = $request->old_image;

        $slide_image = $request->file('slide_image');

        if($slide_image){ // If you want to update only the brand image 
            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($slide_image->getClientOriginalExtension());
            $img_name = $name_gen. '.'.$img_ext;
            $up_location= 'image/slider/';
            $last_img = $up_location.$img_name;
            $slide_image->move($up_location, $img_name);
    
            unlink($old_image);
            // Eloquent ORM
            Slider::find($id)->update([
                'title'=> $request->title,
                'description'=> $request->description,
                'image' => $last_img,
                'created_at' => Carbon::now()
            ]);
            
            return redirect()->back()->with('success', 'Slider Updated Successfully');
        }else{ // If you want to update the brand name only
            Slider::find($id)->update([
                'title' => $request->title,
                'created_at' => Carbon::now()
            ]);
            return redirect()->back()->with('success', 'Slider Updated Successfully');
        }
    }

    public function Delete($id){
        $image = Slider::find($id);
        $old_image = $image->image;
        unlink($old_image);

        Slider::find($id)->delete();
        return redirect()->back()->with('success', 'Slider Deleted Successfully');
    }

}
