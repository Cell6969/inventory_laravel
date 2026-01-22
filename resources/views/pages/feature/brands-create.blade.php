@extends('layout')
@section('page')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <div class="content">
        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Brands</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="{{route('app.brands.all')}}">Brands</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Create Brand</h5>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <form action="{{route('app.brands.store')}}" method="POST" class="row g-3" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    <label for="validationDefault01" class="form-label">Brand Name</label>
                                    <input type="text" name="name" class="form-control" id="validationDefault01" required="">
                                </div>
                                <div class="col-md-6">
                                    <label for="image" class="form-label">Brand Image</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"></label>
                                    <div class="col-lg-12 col-xl-12">
                                        <img id="showImage" src="{{url('no_image.jpg')}}" class="avatar-xl img-thumbnail float-start" alt="image profile"/>
                                    </div>
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
    <script type="text/javascript">
        $(document).ready(function () {
            $('#image').change(function (e) {
                console.log('changed')
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#showImage').attr('src', e.target.result)
                }
                reader.readAsDataURL(e.target.files[0]);
            })
        })
    </script>
@endsection
