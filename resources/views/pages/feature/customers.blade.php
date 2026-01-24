@extends('layout')
@section('page')
    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Customers</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="{{route('app.customers.all')}}">Customers</a></li>
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
                                <a href="{{route('app.customers.create')}}" class="btn btn-secondary">New Customer</a>
                            </div>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Image</th>
                                    <th>Phone</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($customers as $key => $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->email}}</td>
                                        <td><img src="{{(!empty($item->image) ? url($item->image) : url('no_image.jpg'))}}" alt="image brand" style="width: 60px;height: 40px"></td>
                                        <td>{{$item->phone}}</td>
                                        <td>
                                            <a href="{{route('app.customers.edit', $item->id)}}" class="btn btn-info btn-sm">Edit</a>
                                            <form action="{{ route('app.customers.delete', $item->id) }}" method="POST" id="deleteForm{{ $item->id }}" style="display: inline;">
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
@endsection
