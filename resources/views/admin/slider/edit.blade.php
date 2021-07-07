@extends('admin.admin_master')
@section('admin')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong> {{ session('success') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="col-lg-12">
    <div class="card card-default">
        <div class="card-header card-header-border-bottom">
            <h2>Edit Slider</h2>
        </div>
        <div class="card-body">
            <form action="{{ url('update/slider/'.$slider->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="old_image" value="{{ $slider->image }}">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Slider Title</label>
                    <input type="text" name="title" class="form-control" id="exampleFormControlInput1" value="{{ $slider->title }}">
                </div>
               
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Slider Description</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description">{{ $slider->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlFile1">Slider Image</label>
                    <input type="file" name="slide_image" class="form-control-file" id="exampleFormControlFile1" value="{{ $slider->image }}">
                </div>
                <div class="form-group">
                    <img src="{{ asset($slider->image) }}" style="width: 400px; height: 200px;" alt="">
                </div>
                <div class="form-footer pt-4 pt-5 mt-4 border-top">
                    <button type="submit" class="btn btn-primary btn-default">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection