@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Transaction details</h1>
        <a href="{{route('transaction.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')
   
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
      
        </div>

        <form method="POST" action="{{route('transaction.update', ['user' =>$transaction->id])}}">
            @csrf
            @method('PUT')

            <div class="card-body">
           <div class="form-group row">
                    
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0 row m-0">
                      <label class="w-100">  <span style="color:red;" >*</span>Customer</label>
                      <!--<select class="col-md-9 form-control form-control-user @error('customer_id') is-invalid @enderror" name="customer_id" id="customer_id" data-live-search="true">-->
                      <!--      <option selected disabled>Select Customer</option>-->
                             
                      <!--       @foreach ($customers as $customer)-->
                      <!--          <option value="{{$customer->id}}" @if($customer->id == $transaction->customer_id) selected @endif>{{$customer->first_name}}&nbsp;{{  $customer->last_name}}</option>-->
                      <!--      @endforeach-->
                      <!--  </select>-->
                      <!--  <input type='text' class="col-md-3 form-control form-control-user" placeholder="search customer" id="search_customer">-->
                      
                     <div class="dropdown show w-100">
                      <a class="btn btn-white dropdown-toggle form-control form-control-user @error('customer_id') is-invalid @enderror" href="#" role="button" id="customer_name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{$new_user->first_name}} {{$new_user->last_name}}</a>
                    <input type='hidden' class="form-control form-control-user" placeholder="search customer" name="customer_id" id="customer_id" value="{{$new_user->id}}">
                    
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <input type='text' class="form-control form-control-user" placeholder="search customer" id="search_customer">
                        <div id="customer_list">
                        
                            @foreach ($customers as $customer)
                                <a class="dropdown-item" data-customer_id="{{$customer->id}}">{{$customer->first_name}}&nbsp;{{  $customer->last_name}}</a>
                            @endforeach
                        </div>
                      </div>
                    </div>
                      
                    </div>
                    
             
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Date</label>
                    <input 
                        type="date" 
                        class="form-control form-control-user @error('date') is-invalid @enderror" 
                        id="date" 
                        placeholder="date" 
                        name="date" 
                        value="{{ old('date') ? old('date') : $transaction->date }}">
                       
                    </div>
                    
    

                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0 row m-0">
                        <label class="w-100"><span style="color:red;">*</span>Company</label>
                        <!--<input -->
                        <!--    type="text" -->
                        <!--    class="form-control form-control-user @error('company') is-invalid @enderror" -->
                        <!--    id="company"-->
                        <!--    placeholder="Company Name" -->
                        <!--    name="company" -->
                        <!--    value="{{ old('company') ? old('company') : $transaction->company }}">-->
                        
                        <!--<select class="form-control form-control-user @error('company') is-invalid @enderror" name="company">-->
                        <!--    <option selected disabled>Select Company</option>-->
                        <!--    @foreach($companys as $comp)-->
                            
                        <!--    <option value="{{$comp->id}}" @if($comp->id == $transaction->company )selected @endif>{{$comp->name}}</option>-->
                            
                        <!--    @endforeach-->
                        <!--</select>-->
                        
                        <!--<select class="col-md-9 form-control form-control-user @error('company') is-invalid @enderror" name="company" id="company">-->
                        <!--    <option selected disabled>Select Company</option>-->
                        <!--        @foreach($companys as $comp)-->
                            
                        <!--    <option value="{{$comp->id}}" @if($comp->id == $transaction->company)selected @endif>{{$comp->name}}</option>-->
                            
                        <!--    @endforeach-->
                        <!--</select>-->
                        
                        <!--@error('company')-->
                        <!--    <span class="text-danger">{{$message}}</span>-->
                        <!--@enderror-->
                        
                        <!-- <input type='text' class="col-md-3 form-control form-control-user" placeholder="search Company" id="search_company">-->
                        
                                             
                     <div class="dropdown show w-100">
                      <a class="btn btn-white dropdown-toggle form-control form-control-user @error('company') is-invalid @enderror" href="#" role="button" id="company_name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{$new_company->name}}</a>
                       <input type='hidden' class="form-control form-control-user" placeholder="search customer" name="company" id="company" value="{{$new_company->id}}">
                    
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <input type='text' class="form-control form-control-user" placeholder="search Company" id="search_company">
                        <div id="new_company_list">
                        
                            @foreach ($companys as $comp)
                                <a class="dropdown-item" data-company_id="{{$comp->id}}">{{$comp->name}}</a>
                            @endforeach
                        </div>
                      </div>
                    </div>
                   
                    </div>
       
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Amount</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('amount') is-invalid @enderror" 
                            id="amount"
                            placeholder="Amount" 
                            name="amount" 
                            value="{{ old('amount') ? old('amount') : $transaction->amount }}">

                   
                    </div>
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0"><span style="color:red;">*</span>
                      Description</label>
                      <textarea class="form-control form-control-user" id="description" placeholder="Description" rows="1" name="description">{{ old('description') ? old('description') : $transaction->description}}</textarea>  
                      </div>

  <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Status</label>
                        <select class="form-control form-control-user @error('status') is-invalid @enderror" name="status">
                            <option disabled>Select Status</option>
                              <option value="1" @if($transaction->status ==1 )selected @endif> Approved</option>
                            <option value="0" @if($transaction->status ==0 )selected @endif> Pending</option>
                        </select>
                
                    </div>
                    
                    <div class="col-sm-12 mb-3 mt-3 mb-sm-0">
                        <input 
                            type="checkbox" 
                            class="@error('fraud_checked') is-invalid @enderror" 
                            id="fraud_checked"
                            placeholder="Amount" 
                            name="fraud_checked" 
                            value="{{ old('fraud_checked') }}" @if($transaction->is_cheked =='1' )checked @endif>
                            <label for="fraud_checked">Fraud alert pop-up when clicking on client lets talk, maybe they will come back with a new check</label>
                    </div>
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Bank Name</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('bank_name') is-invalid @enderror" 
                            id="bank_name"
                            placeholder="Bank Name" 
                            name="bank_name" 
                            value="{{ old('bank_name') ? old('bank_name') : $transaction->bank_name }}">
                    </div>
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Routing </label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('routing') is-invalid @enderror" 
                            id="routing"
                            placeholder="Routing" 
                            name="routing" 
                            value="{{ old('routing') ? old('routing') : $transaction->routing }}">
                    </div>
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Account Number</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('account_number') is-invalid @enderror" 
                            id="account_number"
                            placeholder="Account Number" 
                            name="account_number" 
                            value="{{ old('account_number') ? old('account_number') : $transaction->account_number }}">
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success btn-user float-right mb-3">Update</button>
                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('transaction.index') }}">Cancel</a>
            </div>
        </form>
    </div>

</div>

 <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
      crossorigin="anonymous"></script>
      
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>



<script>
$(document).ready( function () {
    
    
    $("#customer_id").change(function(){
    
        var id = $(this).val();
        
        // console.log(new_type);
    
        var url = "{{ route('transaction.customercompany') }}"
        
            $.ajax({
            url:url,
            data: {
                    customer_id : id
             },
            dataType: "json",
            success: function(data){
                $("#company").html(data);
                
            }
        });
    });
} );


$(document).ready( function () {
    
    
    $("#search_customer").keyup(function(){
    
        var name = $(this).val();
        
        // console.log(new_type);
    
        var url = "{{ route('transaction.searchcustomer') }}"
        
            $.ajax({
            url:url,
            data: {
                    name : name
             },
            dataType: "json",
            success: function(data){
                $("#customer_list").html(data);
                
            }
        });
    });
} );

$(document).ready( function () {
    
    
    $("#search_company").keyup(function(){
    
        var name = $(this).val();
        var customer_id = $('#customer_id').val();
        
        // console.log(new_type);
    
        var url = "{{ route('transaction.searchcompany') }}"
        
            $.ajax({
            url:url,
            data: {
                    name : name,
                    customer_id : customer_id,
             },
            dataType: "json",
            success: function(data){
                $("#new_company_list").html(data);
                
            }
        });
    });
} );

// $(document).ready( function () {
    
//   $("#customer_list a").on("click", function(){
jQuery(document).ready(function($){
    jQuery(document).on("click","#customer_list a",function(){
       var customer = $(this).text();
       var customer_id = $(this).attr('data-customer_id');
       
       $('#customer_name').text(customer);
       $('#customer_id').val(customer_id);
       $('#company_name').text('');
       $('#company').val('');
       
        var id = customer_id;
        
        // console.log(new_type);
    
        var url = "{{ route('transaction.customercompany') }}"
        
            $.ajax({
            url:url,
            data: {
                    customer_id : id
             },
            dataType: "json",
            success: function(data){
                $("#new_company_list").html(data);
                
            }
        });
    
    });
} );



</script>

<script>
// $(document).ready( function () {
    
//   $("#new_company_list a").on("click", function(){
       
//       var company = $(this).text();
//       var company_id = $(this).attr('data-company_id');
       
//       $('#company_name').text(company);
//       $('#company').val(company_id);

       

//     });
// } );
jQuery(document).ready(function($){
    jQuery(document).on("click","#new_company_list a",function(){
        
       var company = $(this).text();
       var company_id = $(this).attr('data-company_id');
       
       $('#company_name').text(company);
       $('#company').val(company_id);

    
    });
});
</script>




@endsection