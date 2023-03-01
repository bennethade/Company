<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            
            All Category<b> </b>
  
        </h2>
    </x-slot>

    <div class="py-12">
       
        
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                        @endif
                        <div class="card-header">All Category</div>
                    
                        <table class="table table-success table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">S/N</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Category Name</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @php
                                    $i = 1;
                                @endphp --}}
                                @foreach ($categories as $category)
                                    <tr>
                                        {{-- <th scope="row">{{ $i++ }}</th> --}}
                                        <th scope="row">{{ $categories->firstItem()+$loop->index }}</th>  {{-- MAKING NUMBERING TO CONTINUE ON THE NEXT PAGE WITH LINKS() FUNCTION --}}
                                        <td>{{ $category->user->name }}</td>     {{-- FOR ELOQUENT ORM --}}
                                        {{-- <td>{{ $category->name }}</td>      FOR QUERRY BUILDER --}}
                                        <td>{{ $category->category_name }}</td>
                                        
                                        <td>
                                            @if ($category->created_at == NULL)
                                            <span class="text-danger">No Date Set</span>
                                            @else
                                            {{-- {{ $category->created_at->diffForHumans() }} --}}
                                            {{ Carbon\Carbon::parse($category->created_at)->diffForHumans() }}
                                            @endif
                                        </td>    
                                        <td>
                                            <a href="{{ url('category/edit/'.$category->id) }}" class="btn btn-info">Edit</a>
                                            <a href="{{ url('softdelete/category/'.$category->id) }}" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $categories->links() }}

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Add Category</div>
                        <div class="card-body">

                            <form action="{{ route('store.category') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                <label for="exampleInputEmail1" class="form-label">Category Name</label>
                                <input type="text" name="category_name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
                                @error('category_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Add Category</button>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>







{{-- TRASH PART --}}

        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                       
                        <div class="card-header">Trash List</div>
                    
                        <table class="table table-success table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">S/N</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Category Name</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @php
                                    $i = 1;
                                @endphp --}}
                                @foreach ($trashcat as $category)
                                    <tr>
                                        {{-- <th scope="row">{{ $i++ }}</th> --}}
                                        <th scope="row">{{ $categories->firstItem()+$loop->index }}</th>  {{-- MAKING NUMBERING TO CONTINUE ON THE NEXT PAGE WITH LINKS() FUNCTION --}}
                                        <td>{{ $category->user->name }}</td>     {{-- FOR ELOQUENT ORM --}}
                                        {{-- <td>{{ $category->name }}</td>      FOR QUERRY BUILDER --}}
                                        <td>{{ $category->category_name }}</td>
                                        
                                        <td>
                                            @if ($category->created_at == NULL)
                                            <span class="text-danger">No Date Set</span>
                                            @else
                                            {{-- {{ $category->created_at->diffForHumans() }} --}}
                                            {{ Carbon\Carbon::parse($category->created_at)->diffForHumans() }}
                                            @endif
                                        </td>    
                                        <td>
                                            <a href="{{ url('category/restore/'.$category->id) }}" class="btn btn-info">Restore</a>
                                            <a href="{{ url('category/remove/'.$category->id) }}" class="btn btn-danger">Remove</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $trashcat->links() }}

                    </div>
                </div>

                <div class="col-md-4">
                    
                </div>
            </div>
        </div>

{{-- END TRASH --}}








    </div>
</x-app-layout>
