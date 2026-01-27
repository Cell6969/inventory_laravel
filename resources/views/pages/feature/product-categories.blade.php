@extends('layout')
@section('page')
    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Product Categories</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="{{route('app.product-categories.all')}}">Product Categories</a></li>
                        <li class="breadcrumb-item active">All</li>
                    </ol>
                </div>
            </div>

            <!-- Datatables  -->
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <div class="text-end mb-0 mt-0">
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#standard-modal">
                                    New Product Category
                                </button>
                            </div>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($product_categories as $key => $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" id="{{$item->id}}" data-bs-toggle="modal" data-bs-target="#edit-modal" onclick="categoryEdit(this.id)">
                                                Edit
                                            </button>
                                            <form action="{{ route('app.product-categories.delete', $item->id) }}" method="POST" id="deleteForm{{ $item->id }}" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" id="delete">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        </div> <!-- container-fluid -->

    </div>

    {{--  Modal  --}}
    <div class="modal fade" id="standard-modal" tabindex="-1" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="standard-modalLabel">Create Product Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form-control" method="POST" action="{{route("app.product-categories.store")}}">
                    @csrf
                    <div class="modal-body">
                        <div class="col-md-12">
                            <label for="validationDefault01" class="form-label">Category Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid  @enderror" id="validationDefault01">
                            @error('name')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="standard-modalLabel">Edit Product Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form-control" method="POST" action="{{route("app.product-categories.update", ":id")}}" id="editForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="col-md-12">
                            <label for="validationDefault01" class="form-label">Category Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid  @enderror" id="name">
                            @error('name')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function categoryEdit(id) {
            $.ajax({
                type: 'GET',
                url: '/product-categories/edit/' + id,
                dataType: 'json',

                success:function(data) {
                    $("#name").val(data.name);
                    // $("#id").val(data.id);

                    var actionUrl = "/product-categories/edit/" + data.id;
                    $("#editForm").attr("action", actionUrl);
                }
            })
        }
    </script>
@endsection
