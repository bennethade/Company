@extends('admin.admin_master')

@section('admin')


    <div class="py-12">
       
        
        <div class="container">
            <div class="row">

                <h4>Home Slider</h4>
                <a href="{{ route('add.slider') }}"><button class="btn btn-info pull-left">Add Slider</button></a>
                <br><br>

                <div class="col-md-12">
                    <div class="card">
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                        @endif
                        <div class="card-header">All Slider</div>
                    
                        <table class="table table-success table-striped">
                            <thead>
                                <tr>
                                    <th scope="col" width='5%'>S/N</th>
                                    <th scope="col" width='15%'>Slider Title</th>
                                    <th scope="col" width='25%'>Description</th>
                                    <th scope="col" width='10%'>Image</th>
                                    <th scope="col" width='15%'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($sliders as $slider)
                                    <tr>
                                        {{-- <th scope="row">{{ $i++ }}</th> --}}
                                        <td scope="row">{{ $i++ }}</td>  {{-- MAKING NUMBERING TO CONTINUE ON THE NEXT PAGE WITH LINKS() FUNCTION --}}
                                        <td>{{ $slider->title }}</td>     {{-- FOR ELOQUENT ORM --}}
                                        <td>{{ $slider->description }}</td>
                                        {{-- <td>{{ $category->name }}</td>      FOR QUERRY BUILDER --}}
                                        <td><img src="{{ asset($slider->image) }}" alt="" style="height: 40px; width:70px"></td>
                                        
                                        <td>
                                            <a href="{{ url('slider/edit/'.$slider->id) }}" class="btn btn-info">Edit</a>
                                            <a href="{{ url('slider/delete/'.$slider->id) }}" onclick="return confirm('Are you sure to delete this slider?')" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

                
            </div>
        </div>

    </div>

@endsection