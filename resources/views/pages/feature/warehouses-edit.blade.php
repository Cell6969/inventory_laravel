@extends('layout')
@section('page')
    <div class="content">
        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Warehouses</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="{{route('app.warehouses.all')}}">Warehouses</a></li>
                        <li class="breadcrumb-item">Edit</li>
                        <li class="breadcrumb-item active">{{$warehouse->name}}</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Edit Warehouse</h5>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <form action="{{route('app.warehouses.update', $warehouse->id)}}" method="POST" class="row g-3">
                                @csrf
                                @method('PUT')

                                <div class="col-md-6">
                                    <label for="validationDefault01" class="form-label">Warehouse Name</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid  @enderror" id="validationDefault01" value="{{$warehouse->name}}">
                                    @error('name')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="validationDefault01" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid  @enderror" id="validationDefault01" value="{{$warehouse->email}}">
                                    @error('email')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="validationDefault01" class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" id="validationDefault01" value="{{$warehouse->phone}}">
                                </div>
                                <div class="col-md-6">
                                    <label for="validationDefault01" class="form-label">City</label>
                                    <input type="text" name="city" class="form-control" id="validationDefault01" value="{{$warehouse->city}}">
                                </div>
                                <div class="col-md-6">
                                    <label for="validationDefault01" class="form-label">Address</label>
                                    <textarea class="form-control" name="address">{{$warehouse->address}}</textarea>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Save</button>
                                </div>
                            </form>
                        </div> <!-- end card-body -->
                    </div> <!-- end card-->
                </div>
            </div>

        </div> <!-- container-fluid -->

    </div>
@endsection
