@extends('admin.admin_master')

@section('admin')


    <div class="py-12">
       
        
        <div class="container">
            <div class="row">

                <h4>Home About</h4>
                <a href="{{ route('add.about') }}"><button class="btn btn-info pull-left">Add About</button></a>
                <br><br>

                <div class="col-md-12">
                    <div class="card">
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                        @endif
                        <div class="card-header">All About Data</div>
                    
                        <table class="table table-success table-striped">
                            <thead>
                                <tr>
                                    <th scope="col" width='5%'>S/N</th>
                                    <th scope="col" width='15%'>Home Title</th>
                                    <th scope="col" width='20%'>Short Description</th>
                                    <th scope="col" width='25%'>Long Description</th>
                                    <th scope="col" width='15%'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($homeabout as $about)
                                    <tr>
                                        {{-- <th scope="row">{{ $i++ }}</th> --}}
                                        <td scope="row">{{ $i++ }}</td>  {{-- MAKING NUMBERING TO CONTINUE ON THE NEXT PAGE WITH LINKS() FUNCTION --}}
                                        <td>{{ $about->title }}</td>     {{-- FOR ELOQUENT ORM --}}
                                        <td>{{ $about->short_des }}</td>
                                        <td>{{ $about->long_des }}</td>
                                        {{-- <td>{{ $category->name }}</td>      FOR QUERRY BUILDER --}}
                                        
                                        <td>
                                            <a href="{{ url('about/edit/'.$about->id) }}" class="btn btn-info">Edit</a>
                                            <a href="{{ url('about/delete/'.$about->id) }}" onclick="return confirm('Are you sure to delete this about?')" class="btn btn-danger">Delete</a>
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