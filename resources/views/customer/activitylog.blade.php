@extends('layouts.app')

@section('title', 'Customer List')

@section('content')


    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Activity Log Customer ({{$cust_email}})</h1>
            <div class="row">
           
        
                
            </div>

        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
 
          <div class="card-body">
              
            <div class="table-responsive">
                
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%">Sr. No</th>
                                <th width="20%">Customer Name</th>
                                <th width="25%">Role</th>
                                <th width="15%">Name</th>
                                <th width="15%">Email</th>
                                <th width="15%">Date</th>
                                <th width="12%">Activity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activitys as $key => $activity)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $activity->customername }}</td>
                                    <td>{{ $activity->rolename }}</td>
                                    <td>{{ $activity->managename }}</td>
                                    <td>{{ $activity->email }}</td>
                                    <td>{{ $activity->created_at }}</td>
                                    <td>{{ $activity->action }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                
               
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
  $(document).ready( function () {
        
     var table = $('#dataTable').DataTable({

      })
    } );
</script>
    
<script>
function confirmSendEmail(event) {
  event.preventDefault(); // Prevents the default link behavior

  var confirmation = confirm("Are you sure you want to send an email to the customer?");

  if (confirmation) {
    var link = event.target.closest("a");
    var href = link.getAttribute("href");
    window.location.href = href; // Follow the link
  }
}
</script>


@endsection

@section('scripts')
    
@endsection
