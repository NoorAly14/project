@extends('admin.admin_dashboard')
@section('admin')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<div class="page-content"> 
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Inactive Vendor Details</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Inactive Vendor Details</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('active.vendor.approve') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- User Name -->

                                <input type="hidden" name="id" value="{{$inacivesDetails->id}}" />
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">User Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text"  class="form-control" name="username" value="{{$inacivesDetails->username}}" />
                                </div>
                            </div>
                                <!-- Full Name -->
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Shop Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" name="name"  class="form-control" value="{{$inacivesDetails->name}}" />
                                </div>
                            </div>
                                <!-- Email-->
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Vendor Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" name="email"  class="form-control" value="{{$inacivesDetails->email}}" />
                                </div>
                            </div>
                                <!-- Phone-->

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Vendor Phone</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" name="phone" class="form-control" value="{{$inacivesDetails->phone}}" />
                                </div>
                            </div>
                                <!-- Address -->

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Vendor Address</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" name="address" class="form-control" value="{{$inacivesDetails->address}}" />
                                </div>
                            </div>
                                    <!-- Vendor Join Date -->

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Vendor Join</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" name="vendor_join" class="form-control" value="{{$inacivesDetails->vendor_join}}" />
                                </div>
                            </div>
                                     <!-- Vendor Info -->

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Vendor Info</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <textarea name="vendor_short_info" class="form-control" id="inputAddress2" placeholder="Vendor Info" rows="3"
                                        >{{$inacivesDetails->vendor_short_info}}</textarea>
                                </div>
                            </div>
                         
                                <!-- photo  view-->

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0"></h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <img  id="showImage" src="{{ !empty($inacivesDetails->photo) ? url('upload/vendor_images/'.$inacivesDetails->photo) : url('upload/no_image.jpg') }}" 
                                     alt="Admin" style="width:150px;hight:200px;">
                                </div>
                            </div>

                            <!-- save change -->

                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="submit" class="btn btn-danger px-4" value="Active Vendor" />
                                </div>
                            </div>
                           
                        </div> 
                      </form>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#image').change(function(e){
			var reader = new FileReader();
			reader.onload = function(e){
				$('#showImage').attr('src',e.target.result);
			}
			reader.readAsDataURL(e.target.files['0']);
		});
	});
</script>


@endsection