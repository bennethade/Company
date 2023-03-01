@extends('admin.admin_master')

@section('admin')


<div class="col-lg-12">
    <div class="card card-default">
        <div class="card-header card-header-border-bottom">
            <h2>Edit Contact Detail</h2>
        </div>
        <div class="card-body">
            <form action="{{ url('update/contact/'.$contacts->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Contact Address</label>
                    <textarea class="form-control" rows="3" name="address" id="exampleFormControlTextarea1">{{ $contacts->address }}</textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Contact Email</label>
                    <input type="email" name="email" class="form-control" id="exampleFormControlInput1" value="{{ $contacts->email }}">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Contact Phone</label>
                    <input type="text" name="phone" class="form-control" id="exampleFormControlInput1" value="{{ $contacts->phone }}">
                </div>
                
                <div class="form-footer pt-4 pt-5 mt-4 border-top">
                    <button type="submit" class="btn btn-primary btn-default">Update</button>
                </div>
            </form>
        </div>
    </div>





@endsection
