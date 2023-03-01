@extends('admin.admin_master')

@section('admin')


    <div class="py-12">
       
        
        <div class="container">
            <div class="row">

                <h4>Admin Message</h4>
                <br><br>

                <div class="col-md-12">
                    <div class="card">
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                        @endif
                        <div class="card-header">All Message Data</div>
                    
                        <table class="table table-success table-striped">
                            <thead>
                                <tr>
                                    <th scope="col" width='5%'>S/N</th>
                                    <th scope="col" width='15%'>Name</th>
                                    <th scope="col" width='20%'>Email</th>
                                    <th scope="col" width='20%'>Subject</th>
                                    <th scope="col" width='40%'>Message</th>
                                    <th scope="col" width='10%'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($messages as $message)
                                    <tr>
                                        <td scope="row">{{ $i++ }}</td>  {{-- MAKING NUMBERING TO CONTINUE ON THE NEXT PAGE WITH LINKS() FUNCTION --}}
                                        <td>{{ $message->name }}</td>     {{-- FOR ELOQUENT ORM --}}
                                        <td>{{ $message->email }}</td>
                                        <td>{{ $message->subject }}</td>
                                        <td>{{ $message->message }}</td>
                                        
                                        <td>
                                            <a href="{{ url('message/delete/'.$message->id) }}" onclick="return confirm('Are you sure to delete this detail?')" class="btn btn-danger">Delete</a>
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