@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">

    <!-- Page Heading 
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>-->

    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center mb-3">Welcome To BNS Dashboard!</h2>
        </div>
    </div>
    <div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
    Filter By :
        <select id="timePeriod" class="form-control form-control-user" onchange="filterData()">
             <option disabled selected>Over All</option>
            <option value="day">Day</option>
             <option value="yesterday">Yesterday</option>
            <option value="week">Week</option>
            <option value="month">Month</option>
            <option value="year">Year</option>
        </select></div>
        </div>
    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Customers</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="users">{{$users}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Transactions</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="transaction">{{$transactions}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Amount
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" id="amount">{{$totalAmount}}</div>
                                </div>
                            
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($license->count() > 0) { ?>
        <div class="card shadow mb-4">
          <div class="card-header py-3">
           <strong> Customers with expired license </strong>
          </div>
         <div class="card-body">
         <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                              
                                <th width="12%">Name </th>                              
                                <th width="24%">Email </th>
                                
                                <th width="12%">License status </th>                           
                            @hasrole('admin')
                                <th width="30%">Action</th>
                            @endhasrole
                            </tr>
                        </thead>
                        <tbody>
                        <?php $cnt = 1; ?>
                            @foreach ($license as $user)
                                <tr>
                                  
                                    <td>{{ $user->first_name}} {{ $user->last_name }}</td>
                                
                                    <td>{{ $user->email }}</td>
                                   
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

                                     @hasrole('admin') <td style="display: flex">

                                        <a href="{{ route('customer.edit', ['user' => $user->id]) }}" class="btn btn-primary m-2">
                                            <i class="fa fa-pen"> </i>
                                        </a>
                                    
                                        </a>
                                    </td> @endhasrole
                                </tr>
                            @endforeach
                        </tbody>
                    </table>                  
                </div>
            </div>
        </div>
     <?php } ?>
     <?php if ($expiringLicenses->count() > 0) { ?>
        <div class="card shadow mb-4" style="margin-left:10px;">
          <div class="card-header py-3">
           <strong>Customers with expiring license soon</strong>
          </div>
         <div class="card-body">
         <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                              
                                <th width="12%">Name </th>                              
                                <th width="24%">Email </th>
                                
                                <th width="12%">License status </th>                           
                            @hasrole('admin')
                                <th width="30%">Action</th>
                            @endhasrole
                            </tr>
                        </thead>
                        <tbody>
                        <?php $cnt = 1; ?>
                            @foreach ($expiringLicenses as $user)
                                <tr>
                                  
                                    <td>{{ $user->first_name}} {{ $user->last_name }}</td>
                                
                                    <td>{{ $user->email }}</td>
                                   
                               
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

                                     @hasrole('admin') <td style="display: flex">

                                        <a href="{{ route('customer.edit', ['user' => $user->id]) }}" class="btn btn-primary m-2">
                                            <i class="fa fa-pen"> </i>
                                        </a>
                                    
                                        </a>
                                    </td> @endhasrole
                                </tr>
                            @endforeach
                        </tbody>
                    </table>                  
                </div>
            </div>
        </div>
             <?php } ?>
             
             
             
<div class="col-md-12">
    <div class="card shadow mb-4">
                  <div class="card-header py-3">
           <strong>Fraud Transaction List</strong>
          </div>
  <div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
            <thead>
                <tr>
                <th width="3%">ID</th>
                    <th width="10%">Date</th>
                    <th width="12%">Amount</th>
                    <th width="10%">Customer Name</th>
                    <th width="13%">Company Name</th>
                    <th width="5%">Status</th>
                    <!--<th width="12%">View Activity Log </th>-->
                      {{-- @hasanyrole('admin|supervisor')<th width="5%">Action</th> @endhasanyrole --}}
                </tr>
            </thead>
            <tbody>
            <?php $cnt =1; ?>
                @foreach ($fradtransactions as $user)
                 
                            <tr @if($user->is_cheked == '1') style="font-weight: 900; background-color: #FFAFAF;"@endif>
                                <td>{{ $cnt++}} </td>
                                <td>{{ $user->date }}</td>
                                <td>{{ $user->amount }}</td>
                                <td>{{ $user->customer_fullname }}</td>
                                <td>{{ $user->compnyname }}</td>
                                <td>@if ($user->status == 0) Pending @elseif ($user->status == 1)   Approved  @endif</td>
                                <!--<td>-->
                                <!--    <a href="{{ route('transaction.activitylog', ['user' => $user->id]) }}" class="btn btn-primary m-2">Activity Log</a>-->
                                <!--</td>-->
                               {{--  @hasanyrole('admin|supervisor')
                                 <td style="display: flex">
                                    <!-- Action buttons -->

                                    @if ($user->status == 0)
                                            <a href="{{ route('transaction.status', ['user_id' => $user->id, 'status' => 1]) }}"
                                                class="btn btn-success m-2">
                                                <i class="fa fa-check"></i>
                                            </a>
                                        @elseif ($user->status == 1)
                                            <a href="{{ route('transaction.status', ['user_id' => $user->id, 'status' => 0]) }}"
                                                class="btn btn-danger m-2">
                                                <i class="fa fa-ban"></i>
                                            </a>
                                        @endif
                                    <a href="{{ route('transaction.edit', ['user' => $user->id]) }}" class="btn btn-primary m-2">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                 
                                    <a class="btn btn-danger m-2" href="{{ route('transaction.destroy', ['user' => $user->id]) }}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td> @endhasanyrole --}}
                            </tr>
                   
                @endforeach
            </tbody>
        </table>
         {{ $fradtransactions->links() }}
    </div>

</div>
    </div>
</div>
             
             
    </div>

    

</div>
 <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
      crossorigin="anonymous"></script>
      
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js" defer></script>

<script>
    function filterData() {
        var timePeriod = document.getElementById('timePeriod').value;
        // Send AJAX request to the server to get adjusted totals based on the selected time period
        fetch('/public/getAdjustedTotals/' + timePeriod)
            .then(response => response.json())
            .then(data => {
                document.getElementById('users').innerText = data.users;
                document.getElementById('transaction').innerText = data.transactions;
                document.getElementById('amount').innerText = data.totalAmount;
            });
    }
    
    $(document).ready( function () {
        
     var table = $('#dataTable').DataTable({
        pageLength : 5,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']]
      })
    } );
    
    $(document).ready( function () {
        // $('#dataTable1').DataTable();
      var table = $('#dataTable1').DataTable({
        pageLength : 5,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']]
      })
    } );
    
</script>
@endsection