@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Customer</h1>
        <a href="{{route('customer.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')
   
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
      
        </div>

        <form method="POST" class="tab-form" action="{{route('customer.update', ['user' =>$user->id])}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
<div class="card">
    <div class="card-body">
      <ul class="nav nav-tabs" id="formTabs">
        <li class="nav-item">
          <a class="nav-link active" data-tab="tab1" href="#"
            >Personal Info @if ($errors->has('email') ||
            $errors->has('first_name') || $errors->has('last_name') ||
            $errors->has('phone') || $errors->has('dob') ||
            $errors->has('company') || $errors->has('itin_number') || $errors->has('memo') || $errors->has('image'))<i
              class="fa fa-circle"
              style="color: red"
            ></i>
            @endif</a
          >
        </li>
        <li class="nav-item">
          <a class="nav-link" data-tab="tab5" href="#"
            >Company @if ($errors->has('name_list') ||
            $errors->has('rate_list') || $errors->has('phone_list'))<i
              class="fa fa-circle"
              style="color: red"
            ></i>
            @endif</a
          >
        </li>
        <li class="nav-item">
          <a class="nav-link" data-tab="tab2" href="#"
            >Address @if ($errors->has('street_address') || $errors->has('city')
            || $errors->has('state') || $errors->has('zipcode'))
            <i class="fa fa-circle" style="color: red"></i>
            @endif</a
          >
        </li>
        <li class="nav-item">
          <a class="nav-link" data-tab="tab3" href="#"
            >Identification @if ($errors->has('license_number') ||
            $errors->has('license_expire') || $errors->has('license_issue') ||
            $errors->has('sex') || $errors->has('height') || $errors->has('birth_certificate') || $errors->has('passport') || $errors->has('licences') || $errors->has('driver_name') || $errors->has('driver_bdate') || $errors->has('driver_address') || $errors->has('driver_issuing_authority') || $errors->has('birth_full_name') || $errors->has('birth_bdate') || $errors->has('birth_place_of_birth') || $errors->has('birth_parents_name') || $errors->has('birth_registration_number') || $errors->has('birth_issuing_authority') || $errors->has('passport_full_name') || $errors->has('passport_bdate') || $errors->has('passport_number') || $errors->has('passport_nationality') || $errors->has('passport_place_of_birth') || $errors->has('passport_issuing_authority') || $errors->has('passport_Issue_date') || $errors->has('passport_expiry_date'))
            <i class="fa fa-circle" style="color: red"></i>
            @endif</a
          >
        </li>
        <li class="nav-item">
          <a class="nav-link" data-tab="tab4" href="#"
            >Documents @if ($errors->has('documents'))
            <i class="fa fa-circle" style="color: red"></i>
            @endif</a
          >
        </li>
      </ul>

      <div class="tab" id="tab1">
        <div class="form-group row">
          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="first_name"><span style="color:red;">*</span>First Name</label>
            <input
              type="text"
              class="form-control form-control-user @error('first_name') is-invalid @enderror"
              value="{{ old('first_name') ? old('first_name') : $user->first_name }}"
              id="first_name"
              placeholder="First Name"
              name="first_name"
            />
          </div>
          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="last_name"><span style="color:red;">*</span>Last Name</label>
            <input
              type="text"
              class="form-control form-control-user @error('last_name') is-invalid @enderror"
              value="{{ old('last_name') ? old('last_name') : $user->last_name }}"
              id="last_name"
              placeholder="Last Name"
              name="last_name"
            />
          </div>
          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="email"><span style="color:red;">*</span>Email</label>
            <input
              type="text"
              class="form-control form-control-user @error('email') is-invalid @enderror"
              value="{{ old('email') ? old('email') : $user->email }}"
              id="email"
              placeholder="Email"
              name="email"
            />
          </div>
          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="phone"><span style="color:red;">*</span>Phone Number</label>
            <input
              type="text"
              class="form-control form-control-user @error('phone') is-invalid @enderror"
              value="{{ old('phone') ? old('phone') : $user->phone }}"
              id="phone"
              placeholder="Phone Number"
              name="phone"
            />
          </div>
          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="dob"><span style="color:red;">*</span>Date of Birth</label>
            <input
              type="date"
              class="form-control form-control-user @error('dob') is-invalid @enderror"
              id="dob"
              name="dob"
              value="{{ old('dob') ? old('dob') : $user->dob }}"
            />
          </div>
          <!--<div class="col-sm-6 mb-3 mt-3 mb-sm-0">-->
          <!--  <label for="company">Company Name</label>-->
          <!--  <input-->
          <!--    type="text"-->
          <!--    class="form-control form-control-user @error('company') is-invalid @enderror"-->
          <!--    id="company"-->
          <!--    placeholder="Company Name"-->
          <!--    name="company"-->
          <!--    value="{{ old('company') ? old('company') : $user->company }}"-->
          <!--  />-->
          <!--</div>-->
         <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="dob"><span style="color:red;">*</span>social security / itin number</label>
            <input
              type="text"
              class="form-control form-control-user @error('itin_number') is-invalid @enderror"
              id="itin_number"
              name="itin_number"
              value="{{ old('itin_number') ? old('itin_number') : $user->itin_number}}"
            />
          </div>
          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="company" style="font-weight: 900; font-style: italic;">Memo</label>
            <textarea id="memo_field" name="memo" rows="4" cols="80" value="{{ old('memo') }}"  class="form-control form-control-user @error('memo') is-invalid @enderror">{{ old('memo') ? old('memo') : $user->memo}}</textarea>
          </div>
          
          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="fileInput">Upload Image</label>
            <input
              type="file"
              class="form-control-file"
              id="customer_img"
              name="image"
            />
            <p style="color: red">
              @error('image') {{ $message }} @enderror
            </p>
            
             <div class="" id="image_list">
                  <img src="{{ asset('storage/' . $user->image) }}" style="width:80px;" id="profile_img">               
             </div>
            
          </div>
        </div>
      </div>
      
    <div class="tab" id="tab5" style="display: none">
        <div class="form-group row">

          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="cname"><span style="color:red;">*</span>Name</label>
            <input
              type="text"
              class="form-control form-control-user @error('name_list') is-invalid @enderror"
              id="cname"
              placeholder="Name"
              name="cname"
            />
          </div>

          <div class="col-sm-3 mb-3 mt-3 mb-sm-0">
            <label for="rate"><span style="color:red;">*</span>Rate</label>
            <input
              type="number"
              class="form-control form-control-user @error('rate_list') is-invalid @enderror"
              id="rate"
              placeholder="Rate"
              name="rate"
            />
          </div>

          <div class="col-sm-3 mb-3 mt-3 mb-sm-0">
            <label for="cphone"><span style="color:red;">*</span>Phone Number</label>
            <input
              type="text"
              class="form-control form-control-user @error('phone_list') is-invalid @enderror"
              id="cphone"
              placeholder="Phone Number"
              name="cphone"
            />
          </div>
          <div class="col-sm-12 mb-3 mt-3 mb-sm-0">
            <p id="company_error" class="d-none" style="color: red;">this field is required.</p>
          </div>
          <div class="col-sm-12 mb-3 mt-3 mb-sm-0">
            <button type="button" class="btn btn-primary btn-next" id="addcompany">Add</button>
          </div>
          <div class="w-100 mt-5">
              <div class="col-md-12" id="company_list">
                  
                @foreach($companys as $index => $com)
                  <div class="file-item d-flex justify-content-between align-items-center mb-2">
                    <span>{{$com->name}}</span>
                    <span>{{$com->rate}}</span>
                    <span>{{$com->phone}}</span>
                    <button type="button" class="btn btn-sm btn-danger remove-btn"><a href="{{ route('customer.deletecompany', ['companyid' => $com->id]) }}" style="color: white; text-decoration: none;">Remove</a></button>
                  </div>
                 @endforeach
              </div>
          </div>
        </div>
      </div>

      <div class="tab" id="tab2" style="display: none">
        <div class="form-group row">
          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="street_address"><span style="color:red;">*</span>Street Address</label>
            <textarea
              class="form-control form-control-user @error('street_address') is-invalid @enderror"
              id="street_address"
              placeholder="Street Address"
              name="street_address"
              rows="1"
            > {{ old('street_address') ? old('street_address') : $user->street_address }}</textarea
            >
          </div>
          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="city"><span style="color:red;">*</span>City</label>
            <input
              type="text"
              class="form-control form-control-user @error('city') is-invalid @enderror"
              id="city"
              placeholder="City"
              name="city"
              value="{{ old('city') ? old('city') : $user->city }}"
            />
          </div>

          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="state"><span style="color:red;">*</span>State</label>
            <input
              type="text"
              class="form-control form-control-user @error('state') is-invalid @enderror"
              id="state"
              placeholder="State"
              name="state"
              value="{{ old('state') ? old('state') : $user->state }}"
            />
          </div>

          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="zipcode"><span style="color:red;">*</span>Zip Code</label>
            <input
              type="text"
              class="form-control form-control-user @error('zipcode') is-invalid @enderror"
              id="zipcode"
              placeholder="00000"
              name="zipcode"
              value="{{ old('zipcode') ? old('zipcode') : $user->zipcode }}"
            />
          </div>
        </div>
      </div>

      <div class="tab" id="tab3" style="display: none">
        <div class="form-group row">
            
          <h6 class="col-md-12 pt-2"><b>Driver's License:</b></h1>
          
        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="driver_name"><span style="color:red;">*</span>Full Name</label>
            <input
              type="text"
              class="form-control form-control-user @error('driver_name') is-invalid @enderror"
              id="driver_name"
              placeholder="Full Name"
              name="driver_name"
              value="{{ old('driver_name') ? old('driver_name') : $user->driver_name }}"
            />
          </div>
          
        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="driver_bdate"><span style="color:red;">*</span>Date of Birth</label>
            <input
              type="date"
              class="form-control form-control-user @error('driver_bdate') is-invalid @enderror"
              id="driver_bdate"
              placeholder="Date of Birth"
              name="driver_bdate"
              value="{{ old('driver_bdate') ? old('driver_bdate') : $user->driver_bdate }}"
            />
          </div>
          
        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="driver_address"><span style="color:red;">*</span>Address</label>
            <input
              type="text"
              class="form-control form-control-user @error('driver_address') is-invalid @enderror"
              id="driver_address"
              placeholder="Address"
              name="driver_address"
              value="{{ old('driver_address') ? old('driver_address') : $user->driver_address }}"
            />
          </div>
          
          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="driver_issuing_authority"><span style="color:red;">*</span>Issuing Authority</label>
            <input
              type="text"
              class="form-control form-control-user @error('driver_issuing_authority') is-invalid @enderror"
              id="driver_issuing_authority"
              placeholder="Issuing Authority"
              name="driver_issuing_authority"
              value="{{ old('driver_issuing_authority') ? old('driver_issuing_authority') : $user->driver_issuing_authority }}"
            />
          </div>
            
          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="license_number"><span style="color:red;">*</span>License Number</label>
            <input
              type="text"
              class="form-control form-control-user @error('license_number') is-invalid @enderror"
              id="license_number"
              placeholder="License Number"
              name="license_number"
              value="{{ old('license_number') ? old('license_number') : $user->license_number }}"
            />
          </div>

          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="license_expire"><span style="color:red;">*</span>License Expiration Date</label>
            <input
              type="date"
              class="form-control form-control-user @error('license_expire') is-invalid @enderror"
              id="license_expire"
              name="license_expire"
              value="{{ old('license_expire') ? old('license_expire') : $user->license_expire }}"
            />
          </div>

          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="license_issue"><span style="color:red;">*</span>License Issue Date</label>
            <input
              type="date"
              class="form-control form-control-user @error('license_issue') is-invalid @enderror"
              id="license_issue"
              name="license_issue"
              value="{{ old('license_issue') ? old('license_issue') : $user->license_issue }}"

            />
          </div>

          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="sex"><span style="color:red;">*</span>Sex</label>
            <input
              type="text"
              class="form-control form-control-user @error('sex') is-invalid @enderror"
              id="sex"
              placeholder="Sex"
              name="sex"
              value="{{ old('sex') ? old('sex') : $user->sex }}"
            />
          </div>

          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="height"><span style="color:red;">*</span>Height</label>
            <input
              type="text"
              class="form-control form-control-user @error('height') is-invalid @enderror"
              id="height"
              placeholder="Height"
              name="height"
              value="{{ old('height') ? old('height') : $user->height }}"
            />
          </div>
         <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="licences">Upload Licences</label>
            <input
              type="file"
              class="form-control-file"
              id="licences"
              name="licences"
            />
            <p style="color: red">
              @error('licences') {{ $message }} @enderror
            </p>
          </div>
          
          <h6 class="col-md-12 pt-2"><b>Birth Certificate:</b></h1>
          
         <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="birth_full_name"><span style="color:red;">*</span>Full Name</label>
            <input
              type="text"
              class="form-control form-control-user @error('birth_full_name') is-invalid @enderror"
              id="birth_full_name"
              placeholder="Full Name"
              name="birth_full_name"
              value="{{ old('birth_full_name') ? old('birth_full_name') : $user->birth_full_name }}"
            />
          </div>
          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="birth_bdate"><span style="color:red;">*</span>Date of Birth</label>
            <input
              type="date"
              class="form-control form-control-user @error('birth_bdate') is-invalid @enderror"
              id="birth_bdate"
              placeholder="Date of Birth"
              name="birth_bdate"
              value="{{ old('birth_bdate') ? old('birth_bdate') : $user->birth_bdate }}"
            />
          </div>
          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="birth_place_of_birth"><span style="color:red;">*</span>Place of Birth</label>
            <input
              type="text"
              class="form-control form-control-user @error('birth_place_of_birth') is-invalid @enderror"
              id="birth_place_of_birth"
              placeholder="Place of Birth"
              name="birth_place_of_birth"
              value="{{ old('birth_place_of_birth') ? old('birth_place_of_birth') : $user->birth_place_of_birth }}"
            />
          </div>
          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="birth_parents_name"><span style="color:red;">*</span>Parents' Names</label>
            <input
              type="text"
              class="form-control form-control-user @error('birth_parents_name') is-invalid @enderror"
              id="birth_parents_name"
              placeholder="Parents' Names"
              name="birth_parents_name"
              value="{{ old('birth_parents_name') ? old('birth_parents_name') : $user->birth_parents_name }}"
            />
          </div>
          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="birth_registration_number"><span style="color:red;">*</span>Registration Number</label>
            <input
              type="text"
              class="form-control form-control-user @error('birth_registration_number') is-invalid @enderror"
              id="birth_registration_number"
              placeholder="Registration Number"
              name="birth_registration_number"
              value="{{ old('birth_registration_number') ? old('birth_registration_number') : $user->birth_registration_number }}"
            />
          </div>
          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="birth_issuing_authority"><span style="color:red;">*</span>Issuing Authority</label>
            <input
              type="text"
              class="form-control form-control-user @error('birth_issuing_authority') is-invalid @enderror"
              id="birth_issuing_authority"
              placeholder="Issuing Authority"
              name="birth_issuing_authority"
              value="{{ old('birth_issuing_authority') ? old('birth_issuing_authority') : $user->birth_issuing_authority }}"
            />
          </div>
          
          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="birth_certificate">Upload Birth Certificate</label>
            <input
              type="file"
              class="form-control-file"
              id="birth_certificate"
              name="birth_certificate"
            />
            <p style="color: red">
              @error('birth_certificate') {{ $message }} @enderror
            </p>
          </div>
          
          <h6 class="col-md-12 pt-2"><b>Passport:</b></h1>
          
          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="passport_full_name"><span style="color:red;">*</span>Full Name</label>
            <input
              type="text"
              class="form-control form-control-user @error('passport_full_name') is-invalid @enderror"
              id="passport_full_name"
              placeholder="Full Name"
              name="passport_full_name"
              value="{{ old('passport_full_name') ? old('passport_full_name') : $user->passport_full_name }}"
            />
          </div>
          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="passport_bdate"><span style="color:red;">*</span>Date of Birth</label>
            <input
              type="date"
              class="form-control form-control-user @error('passport_bdate') is-invalid @enderror"
              id="passport_bdate"
              placeholder="Date of Birth"
              name="passport_bdate"
              value="{{ old('passport_bdate') ? old('passport_bdate') : $user->passport_bdate }}"
            />
          </div>
          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="passport_number"><span style="color:red;">*</span>Passport Number</label>
            <input
              type="text"
              class="form-control form-control-user @error('passport_number') is-invalid @enderror"
              id="passport_number"
              placeholder="Passport Number"
              name="passport_number"
              value="{{ old('passport_number') ? old('passport_number') : $user->passport_number }}"
            />
          </div>
          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="passport_nationality"><span style="color:red;">*</span>Nationality</label>
            <input
              type="text"
              class="form-control form-control-user @error('passport_nationality') is-invalid @enderror"
              id="passport_nationality"
              placeholder="Nationality"
              name="passport_nationality"
              value="{{ old('passport_nationality') ? old('passport_nationality') : $user->passport_nationality }}"
            />
          </div>
          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="passport_place_of_birth"><span style="color:red;">*</span>Place of Birth</label>
            <input
              type="text"
              class="form-control form-control-user @error('passport_place_of_birth') is-invalid @enderror"
              id="passport_place_of_birth"
              placeholder="Place of Birth"
              name="passport_place_of_birth"
              value="{{ old('passport_place_of_birth') ? old('passport_place_of_birth') : $user->passport_place_of_birth }}"
            />
          </div>
          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="passport_issuing_authority"><span style="color:red;">*</span>Issuing Authority</label>
            <input
              type="text"
              class="form-control form-control-user @error('passport_issuing_authority') is-invalid @enderror"
              id="passport_issuing_authority"
              placeholder="Issuing Authority"
              name="passport_issuing_authority"
              value="{{ old('passport_issuing_authority') ? old('passport_issuing_authority') : $user->passport_issuing_authority }}"
            />
          </div>
          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="passport_Issue_date"><span style="color:red;">*</span>Passport Issue Date</label>
            <input
              type="date"
              class="form-control form-control-user @error('passport_Issue_date') is-invalid @enderror"
              id="passport_Issue_date"
              placeholder="Passport Issue Date"
              name="passport_Issue_date"
              value="{{ old('passport_Issue_date') ? old('passport_Issue_date') : $user->passport_Issue_date }}"
            />
          </div>
          <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="passport_expiry_date"><span style="color:red;">*</span>Passport Expiry Date</label>
            <input
              type="date"
              class="form-control form-control-user @error('passport_expiry_date') is-invalid @enderror"
              id="passport_expiry_date"
              placeholder="Passport Expiry Date"
              name="passport_expiry_date"
              value="{{ old('passport_expiry_date') ? old('passport_expiry_date') : $user->passport_expiry_date }}"
            />
          </div>
          
         <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
            <label for="passport">Upload Passport</label>
            <input
              type="file"
              class="form-control-file"
              id="passport"
              name="passport"
            />
            <p style="color: red">
              @error('passport') {{ $message }} @enderror
            </p>
          </div>
        </div>
      </div>

      <div class="tab" id="tab4" style="display: none">
        <div class="form-group row">
          <div class="col-sm-12 mb-3 mt-3 mb-sm-0">
            <label for="fileInput"><span style="color:red;">*</span>Upload Files</label>
            <input
              type="file"
              class="form-control-file"
              id="fileInput"
              name="documents[]"
              multiple
            />
            <p style="color: red">
              @error('documents') {{ $message }} @enderror
            </p>
          </div>
          <div class="col-sm-12 mb-3 mt-3 mb-sm-0">
          <ul style="padding-left:1px !important">

      @foreach($uploadedDocuments as $index => $document)
        <li id="{{ $document }}" style="display: flex; justify-content: space-between; align-items: center; margin-bottom:10px"> 
            <a href="{{ asset('storage/' . $document) }}" target="_blank"> Document {{ $index + 1 }} </a>
            <button type="button" class="btn btn-danger btn-sm" onclick="removeDocument('{{ $document }}')">Remove</button>
        </li>  
      @endforeach


            </ul>
            <div id="fileList"></div>
          </div>
        </div>
      </div>
    </div>

    <div class="card-footer">
      <button
        type="button"
        class="btn btn-primary btn-prev"
        onclick="prevTab()"
      >
        Previous
      </button>
      <button
        type="button"
        class="btn btn-primary btn-next"
        onclick="nextTab()"
      >
        Next
      </button>
      <button type="submit" class="btn btn-success btn-submit">Submit</button>
      <a class="btn btn-danger" href="{{ route('customer.index') }}">Cancel</a>
    </div>
  </div>
           
        </form>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!--<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>-->
  <script src="https://cdn.tiny.cloud/1/bf79bdo3a35xw6p2razl2nccn1fvfmq729zonn7ajz7vdcmr/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

  
  <script>
    function removeDocument(filename) {
        let input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'removed_documents[]';

       input.value = filename
        document.querySelector('form').appendChild(input);

    
        const liElement = document.getElementById(`${filename}`);
        if (liElement) {
            liElement.remove();
        }
    }
</script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const formTabs = document.querySelectorAll('.nav-tabs .nav-link');
      const tabs = document.querySelectorAll('.tab');

      formTabs.forEach((tab, index) => {
        tab.addEventListener('click', function(event) {
          event.preventDefault();
          formTabs.forEach((t) => t.classList.remove('active'));
          tabs.forEach((tab) => (tab.style.display = 'none'));

          tab.classList.add('active');
          tabs[index].style.display = 'block';
        });
      });
    });

    function nextTab() {
      const formTabs = document.querySelectorAll('.nav-tabs .nav-link');
      const currentTabId = document.querySelector('.tab-form .tab:not([style*="none"])').id;
      const currentIndex = Array.from(formTabs).findIndex(tab => tab.getAttribute('data-tab') === currentTabId);
      const nextTabId = formTabs[currentIndex + 1]?.getAttribute('data-tab');

      if (nextTabId) {
        showTab(nextTabId);
      }
    }

    function prevTab() {
      const formTabs = document.querySelectorAll('.nav-tabs .nav-link');
      const currentTabId = document.querySelector('.tab-form .tab:not([style*="none"])').id;
      const currentIndex = Array.from(formTabs).findIndex(tab => tab.getAttribute('data-tab') === currentTabId);
      const prevTabId = formTabs[currentIndex - 1]?.getAttribute('data-tab');

      if (prevTabId) {
        showTab(prevTabId);
      }
    }

    function showTab(tabId) {
      const formTabs = document.querySelectorAll('.nav-tabs .nav-link');
      formTabs.forEach(tab => tab.classList.remove('active'));

      const currentTab = document.querySelector('.tab-form .tab:not([style*="none"])');
      currentTab.style.display = 'none';

      const targetTab = document.getElementById(tabId);
      targetTab.style.display = 'block';

      const activeTabLink = document.querySelector(`[data-tab="${tabId}"]`);
      activeTabLink.classList.add('active');
    }

    function submitForm() {
      // You can add form validation here before submitting the data
      const formData = new FormData(document.querySelector('.tab-form'));
      // Send the form data to the server using AJAX or handle it in any way you want
      console.log('Form data:', Object.fromEntries(formData));
    }
  </script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
      const fileInput = document.getElementById('fileInput');
      const fileList = document.getElementById('fileList');






      fileInput.addEventListener('change', function() {
        const files = Array.from(fileInput.files);
        files.forEach(file => {

              xname = file.name;
              let trimmedxname; 
              if (xname.length > 18) {
                let trimmedValue = xname.substring(0, 18);

                trimmedxname= trimmedValue + "...";
              } 
              else {
                trimmedxname = xname;
              
              }

          const listItem = document.createElement('div');
          listItem.classList.add('file-item', 'd-flex', 'justify-content-between', 'align-items-center', 'mb-2');
          listItem.innerHTML = `
            <span>${trimmedxname}</span>
            <button type="button" class="btn btn-sm btn-danger remove-btn" data-file="${file.name}">Remove</button>
          `;
          fileList.appendChild(listItem);
        });
      });

      fileList.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-btn')) {
          const listItem = event.target.parentElement;
          fileList.removeChild(listItem);
        }
      });


    });
  </script>
  
  <script>
  document.addEventListener('DOMContentLoaded', function() {
      
      document.getElementById('customer_img').onchange = function () {
      var src = URL.createObjectURL(this.files[0])
      
        document.getElementById("profile_img").src = src;

    }
 });
 
  document.addEventListener('DOMContentLoaded', function() {
      
      document.getElementById('addcompany').onclick = function () {
          
          var cname = document.getElementById('cname').value;
          var rate = document.getElementById('rate').value;
          var cphone = document.getElementById('cphone').value;
          var company_list = document.getElementById('company_list');
          
          if(cname == '' || rate == '' || cphone == ''){
              document.getElementById('company_error').classList.remove('d-none');
          }
          else{
              
              document.getElementById('company_error').classList.add('d-none');
              
            var listItem = document.createElement('div');
              listItem.classList.add('file-item', 'd-flex', 'justify-content-between', 'align-items-center', 'mb-2');
              
              listItem.innerHTML = `
               <input type="hidden" name="name_list[]" value="`+cname+`">
               <input type="hidden" name="rate_list[]" value="`+rate+`">
               <input type="hidden" name="phone_list[]" value="`+cphone+`">
                <span>`+cname+`</span>
                <span>`+rate+`</span>
                <span>`+cphone+`</span>
                <button type="button" class="btn btn-sm btn-danger remove-btn">Remove</button>
              `;
              company_list.appendChild(listItem);
              
               document.getElementById('cname').value = "";
               document.getElementById('rate').value = "";
               document.getElementById('cphone').value = "";
              
          }
          
    }
    
    company_list.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-btn')) {
          const listItem = event.target.parentElement;
          company_list.removeChild(listItem);
        }
      });
    
    
  });
  
  </script>
  

      <script>
      tinymce.init({
        selector: '#memo_field'
      });
    </script>
  

@endsection