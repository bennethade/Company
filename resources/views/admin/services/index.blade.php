@extends('admin.admin_master')

@section('admin')


    <div class="py-12">
       
        
        <div class="container">
            <div class="row">

                <h4>Home Services</h4>
                <a href="{{ route('add.service') }}"><button class="btn btn-info pull-left">Add Service</button></a>
                <br><br>

                <div class="col-md-12">
                    <div class="card">
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                        @endif
                        <div class="card-header">All Service Data</div>
                    
                        <table class="table table-success table-striped">
                            <thead>
                                <tr>
                                    <th scope="col" width='5%'>S/N</th>
                                    <th scope="col" width='15%'>Service Title</th>
                                    <th scope="col" width='20%'>Description</th>
                                    <th scope="col" width='15%'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($services as $service)
                                    <tr>
                                        {{-- <th scope="row">{{ $i++ }}</th> --}}
                                        <td scope="row">{{ $i++ }}</td>  {{-- MAKING NUMBERING TO CONTINUE ON THE NEXT PAGE WITH LINKS() FUNCTION --}}
                                        <td>{{ $service->title }}</td>     {{-- FOR ELOQUENT ORM --}}
                                        <td>{{ $service->description }}</td>
                                        {{-- <td>{{ $category->name }}</td>      FOR QUERRY BUILDER --}}
                                        
                                        <td>
                                            <a href="{{ url('service/edit/'.$service->id) }}" class="btn btn-info">Edit</a>
                                            <a href="{{ url('service/delete/'.$service->id) }}" onclick="return confirm('Are you sure to delete this service?')" class="btn btn-danger">Delete</a>
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