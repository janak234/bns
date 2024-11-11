@extends('layouts.app')

@section('title', 'Customer List')

@section('content')
<style>
@media screen and (max-width: 767px) {
    .card-header div {
        display: block;
        margin: 5px 0;
        text-align: left;
    }
}
</style>
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Customer List</h1>
            <div class="row">                               
            </div>

        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">

 <form action="{{ route('customer.search') }}" method="POST">
    @csrf
<div class="card-header py-3">
    <div class="row">
   
        <div class="col-md-4 text-md-left">
            <select class="form-control form-control-user" name="item" required>
                <option disabled>Search By</option>
                <option value="name" selected>Name</option>
                <option value="email" @if(isset($item)) @if($item=='email') selected @endif @endif> Email</option>
                <option value="company" @if(isset($item)) @if($item=='company') selected @endif @endif> Company</option>
                <option value="phone" @if(isset($item)) @if($item=='phone') selected @endif @endif> Phone</option>
                <option value="city" @if(isset($item)) @if($item=='city') selected @endif @endif> City</option>
                <option value="street_address" @if(isset($item)) @if($item=='street_address') selected @endif @endif >Address</option>
                <option value="state" @if(isset($item)) @if($item=='state') selected @endif @endif >State</option>
                <option value="zipcode" @if(isset($item)) @if($item=='zipcode') selected @endif @endif> Zipcode</option>
                <option value="license_number" @if(isset($item)) @if($item=='license_number') selected @endif @endif> License Number</option>        
            </select>
        </div>
        <div class="col-md-4 mt-2 mt-md-0 text-md-left">
            <input type="text" class="form-control form-control-user" id="keyword" placeholder="Keyword" name="keyword" value="@if(isset($keyword)) {{$keyword}} @endif" required>
        </div>
        <div class="col-md-2 mt-2 mt-md-0 text-md-left">
          <button type="submit" class="d-sm-inline-block btn btn-primary shadow-sm">
                <i class="fas fa-search"></i> Search
            </button>
            @if(isset($item))
          <a href="{{ route('customer.index') }}" title="Clear Filter!" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                 X
            </a>
            @endif
        </div>
     
        <div class="col-md-2 mt-2 mt-md-0 text-md-right">
            <a href="{{ route('customer.create') }}" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm"></i> Add New Customer
            </a>
        </div>
    
    </div>
</div>
</form>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="7%">ID </th>
                                <th width="12%">First Name </th>   
                                <th width="12%">Last Name </th>                              
                                <th width="24%">Email </th>
                                <!--<th width="16%">Company Name </th>  -->
                                <th width="12%">License status </th>
                                <th width="12%">View Transactions </th>
                                <th width="12%">View Activity Log </th>
                            @hasanyrole('admin|supervisor')
                                <th width="30%">Action</th>
                           @endhasanyrole
                            </tr>
                        </thead>
                        <tbody>
                        <?php $cnt = 1; ?>
                            @foreach ($users as $user)
                                <tr>
                                     <td>{{ $cnt }}</td>
                                    <td>{{ $user->first_name}}</td>
                                     <td>{{ $user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                   
                                    <!--<td>{{ $user->company }}</td>-->
                                    <td>
                                        <?php 
                                        $cnt++;
                                            $currentDate = new DateTime();
                                            $licenseExpireDate = new DateTime($user->license_expire);
                                            $interval = $currentDate->diff($licenseExpireDate);
                                            $daysRemaining = $interval->format('%r%a');
                                            if($daysRemaining < 0){
                                        ?>
                                        <span class="badge badge-danger">Expired</span>
                                        <?php
                                            }
                                            else if($daysRemaining === -0){
                                        ?>
                                        
                                        <?php
                                            }
                                            else if($daysRemaining >= 0 && $daysRemaining < 8)
                                            {
                                        ?>
                                          <span class="badge badge-warning">Expiring soon </span>
                                        <?php        
                                            }
                                            else if($daysRemaining >= 8){
                                        ?>
                                        <span class="badge badge-success"> Valid </span>
                                        <?php
                                            }
                            
                                        ?>

                                    </td>
                                    
                                    <td>
                                        <a href="{{ route('customer.customertransaction', ['user' => $user->id]) }}" class="btn btn-primary m-2">
                                            View Transactions
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('customer.activitylog', ['user' => $user->id]) }}" class="btn btn-primary m-2">Activity Log</a>
                                    </td>
                                    @hasanyrole('admin|supervisor') <td style="display: flex">

                                        <a href="{{ route('customer.edit', ['user' => $user->id]) }}" class="btn btn-primary m-2">
                                            <i class="fa fa-pen"> </i>
                                        </a>
                                        <a class="btn btn-danger m-2" href="{{ route('customer.destroy', ['user' => $user->id]) }}" >
                                            <i class="fas fa-trash"> </i>
                                        </a>
                                    </td>  @endhasanyrole
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                   
                </div>
            </div>
        </div>
           <!--{{ $users->links() }}-->
    </div>



 <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
      crossorigin="anonymous"></script>
      
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js" defer></script>

<script>
  $(document).ready( function () {
        
     var table = $('#dataTable').DataTable({

      })
    } );
</script>


@include('customer.delete-modal')

@endsection

@section('scripts')
    
@endsection
