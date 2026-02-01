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
                        <li class="breadcrumb-item">Show</li>
                        <li class="breadcrumb-item active">{{$product->name}}</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-sm-center flex-sm-row flex-colum">
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-0">Show Product</h5>
                                </div>
                                <div class="text-end">
                                    <ol class="breadcrumb m-0 py-0">
                                        <a href="{{ route('app.products.all') }}" class="btn btn-outline-secondary me-2">Back</a>
                                        <a href="{{ route('app.products.edit', $product->id) }}" class="btn btn-primary">Edit</a>
                                    </ol>
                                </div>
                            </div>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <h5 class="mb-3">Image</h5>
                                    <div class="d-flex flex-wrap">
                                        @forelse($product_images as $images)
                                            <img src="{{ asset($images->image) }}" alt="image" class="me-2 mb-2" width="100" height="100" style="object-fit: cover; border: 1px solid #ddd; border-radius: 5px">
                                        @empty
                                            <p class="text-danger">No Image Available</p>
                                        @endforelse
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h5 class="mb-3">Product Information</h5>
                                    <ul class="list-group">
                                        <li class="list-group-item"><strong>Name:</strong> {{ $product->name }} </li>
                                        <li class="list-group-item"><strong>Code:</strong> {{ $product->code }} </li>
                                        <li class="list-group-item"><strong>Warehouse:</strong> {{ $product->warehouse->name }} </li>
                                        <li class="list-group-item"><strong>Supplier:</strong> {{ $product->vendor->name ?? '' }} </li>
                                        <li class="list-group-item"><strong>Category:</strong> {{ $product->product_category->name ?? '' }} </li>
                                        <li class="list-group-item"><strong>Brand:</strong> {{ $product->brand->name ?? '' }} </li>
                                        <li class="list-group-item"><strong>Price:</strong> {{ $product->price }} </li>
                                        <li class="list-group-item"><strong>Stock Aleart:</strong> {{ $product->stock_alert }} </li>
                                        <li class="list-group-item"><strong>Product Qty:</strong> {{ $product->quantity }} </li>
                                        <li class="list-group-item"><strong>Product Status:</strong> {{ $product->status }} </li>
                                        <li class="list-group-item"><strong>Product Note:</strong> {{ $product->note }} </li>
                                        <li class="list-group-item"><strong>Create On:</strong>
                                            {{ \Carbon\Carbon::parse($product->created_at)->format('d F Y')  }} </li>
                                    </ul>
                                </div>
                            </div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card-->
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div>
@endsection
