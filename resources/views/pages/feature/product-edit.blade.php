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
                        <li class="breadcrumb-item">Edit</li>
                        <li class="breadcrumb-item active">{{$product->name}}</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Edit Product</h5>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <form action="{{route("app.products.update", $product->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="row">
                                                <div class="col-md-12 mb-2">
                                                    <h3>Information</h3>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Product Image</label>
                                                    <div class="mb-3">
                                                        <input name="image[]" accept=".png, .jpg, .jpeg" multiple=""
                                                               type="file" id="multiImg"
                                                               class="upload-input-file form-control">
                                                    </div>

                                                    <div class="row" id="preview_img">
                                                        @if(isset($product) && $product->images->count() > 0)
                                                            @foreach($product->images as $image)
                                                                <div class="col-md-2 mb-2">
                                                                    <img src="{{asset($image->image)}}" alt="product image" class="img-thumbnail" height="100px">
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="name" placeholder="Enter Name"
                                                           class="form-control @error('name') is-invalid @enderror" value="{{$product->name}}">
                                                    @error('name')
                                                    <div class="invalid-feedback">
                                                        {{$message}}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Code <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="code"
                                                           class=" form-control @error('code') is-invalid @enderror"
                                                           placeholder="Enter Code" value="{{$product->code}}">
                                                    @error('code')
                                                    <div class="invalid-feedback">
                                                        {{$message}}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group w-100">
                                                        <label class="form-label" for="formBasic">Product
                                                            Category</label>
                                                        <select name="product_category_id" id="product_category_id"
                                                                class="form-control form-select">
                                                            <option value="">Select Category</option>
                                                            @foreach ($categories as $item)
                                                                <option value="{{ $item->id }}" @if($product->product_category_id == $item->id) selected @endif>
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group w-100">
                                                        <label class="form-label" for="formBasic">Brand</label>
                                                        <select name="brand_id" id="brand_id"
                                                                class="form-control form-select">
                                                            <option value="">Select Brand</option>
                                                            @foreach ($brands as $item)
                                                                <option
                                                                    value="{{ $item->id }}" @if($product->brand_id == $item->id) selected @endif>{{ $item->name }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Product Price <span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" name="price"
                                                           class="form-control @error('price') is-invalid @enderror"
                                                           placeholder="Enter product price" min="0" value="{{$product->price}}">
                                                    @error('price')
                                                    <div class="invalid-feedback">
                                                        {{$message}}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Stock Alert <span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" name="stock_alert"
                                                           class="form-control @error('stock_alert') is-invalid @enderror"
                                                           placeholder="Enter Stock Alert" min="0" required value="{{$product->stock_alert}}">
                                                    @error('stock_alert')
                                                    <div class="invalid-feedback">
                                                        {{$message}}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label">Notes </label>
                                                    <textarea class="form-control" name="note" rows="3"
                                                              placeholder="Enter Notes">{{$product->note}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="row">
                                                <div class="col-md-12 mb-2">
                                                    <h3>Stock</h3>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <div class="form-group w-100">
                                                        <label class="form-label" for="formBasic">Warehouse <span
                                                                class="text-danger">*</span></label>
                                                        <select name="warehouse_id" id="warehouse_id"
                                                                class="form-control form-select @error('warehouse_id') is-invalid  @enderror">
                                                            <option value="">Select Warehouse</option>
                                                            @foreach ($warehouses as $item)
                                                                <option
                                                                    value="{{ $item->id }}" @if($product->warehouse_id == $item->id) selected @endif>{{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('warehouse_id')
                                                        <div class="invalid-feedback">
                                                            {{$message}}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <div class="form-group w-100">
                                                        <label class="form-label" for="formBasic">Vendor</label>
                                                        <select name="vendor_id" id="vendor_id"
                                                                class="form-control form-select">
                                                            <option value="">Select Vendor</option>
                                                            @foreach ($vendors as $item)
                                                                <option
                                                                    value="{{ $item->id }}" @if($product->vendor_id == $item->id) selected @endif>{{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Product Quantity <span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" name="quantity"
                                                           class="form-control @error('quantity') is-invalid @enderror"
                                                           placeholder="Enter Product Quantity" min="1" required value="{{$product->quantity}}">
                                                    @error('quantity')
                                                    <div class="invalid-feedback">
                                                        {{$message}}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group w-100">
                                                        <label class="form-label" for="formBasic">Status <span
                                                                class="text-danger">*</span></label>
                                                        <select name="status" id="status"
                                                                class="form-control form-select @error('status') is-invalid @enderror">
                                                            <option value="Received" @if($product->status == 'Received') selected @endif>Received</option>
                                                            <option value="Pending" @if($product->status == 'Pending') selected @endif>Pending</option>
                                                        </select>
                                                        @error('status')
                                                        <div class="invalid-feedback">
                                                            {{$message}}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="d-flex mt-5 justify-content-start">
                                            <button class="btn btn-primary me-3" type="submit">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div> <!-- end card-body -->
                    </div> <!-- end card-->
                </div>
            </div>

        </div> <!-- container-fluid -->

    </div>
    <script>
        document.getElementById('multiImg').addEventListener('change', function (event) {
            const previewContainer = document.getElementById('preview_img');
            previewContainer.innerHTML = ''; // Clear previous previews

            const files = Array.from(event.target.files); // Convert FileList to Array
            const input = event.target;

            files.forEach((file, index) => {
                // Check if the file is an image
                if (file.type.match('image.*')) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        // Create preview container
                        const col = document.createElement('div');
                        col.className = 'col-md-2 mb-3';

                        // Create image
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-fluid rounded';
                        img.style.maxHeight = '100px';
                        img.alt = 'Image Preview';

                        // Create remove button
                        const removeBtn = document.createElement('button');
                        removeBtn.type = 'button';
                        removeBtn.className = 'btn btn-danger btn-sm position-absolute';
                        removeBtn.style.top = '10px';
                        removeBtn.style.right = '5px';
                        removeBtn.innerHTML = '&times;'; // Cross icon
                        removeBtn.title = 'Remove Image';

                        // Remove button functionality
                        removeBtn.addEventListener('click', function () {
                            col.remove(); // Remove the image preview
                            // Update the file input by creating a new FileList
                            const newFiles = files.filter((_, i) => i !== index);
                            const dataTransfer = new DataTransfer();
                            newFiles.forEach(f => dataTransfer.items.add(f));
                            input.files = dataTransfer.files;
                        });

                        // Create wrapper for positioning
                        const wrapper = document.createElement('div');
                        wrapper.style.position = 'relative';
                        wrapper.appendChild(img);
                        wrapper.appendChild(removeBtn);

                        col.appendChild(wrapper);
                        previewContainer.appendChild(col);
                    };

                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endsection
