@extends('layout')
@section('page')
    <div class="content">
        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Products</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="{{route('app.products.all')}}">Products</a></li>
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
                                <a href="{{route('app.products.create')}}" class="btn btn-secondary">New Product</a>
                            </div>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Warehouse</th>
                                    <th>Price</th>
                                    <th>In Stock</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $key => $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>
                                            @php
                                                $first_image = $item->images()->first()->image ?? "/no_image.jpg"
                                            @endphp
                                            <img src="{{asset($first_image)}}" alt="image product {{$key+1}}" width="40px">
                                        </td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->warehouse->name}}</td>
                                        <td>Rp. {{$item->price}}</td>
                                        <td>{{$item->quantity}}</td>
                                        <td>
                                            <a href="{{route('app.vendors.edit', $item->id)}}" class="btn btn-success btn-sm">
                                                <span class="mdi mdi-eye"></span>
                                            </a>
                                            <a href="{{route('app.products.edit', $item->id)}}" class="btn btn-info btn-sm">
                                                <span class="mdi mdi-book-edit"></span>
                                            </a>
                                            <form action="{{ route('app.products.delete', $item->id) }}" method="POST" id="deleteForm{{ $item->id }}" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" id="delete"><span class="mdi mdi-delete"></span></button>
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
@endsection
