@extends('layouts.app')

@section('title', 'Customer List')

@section('content')


    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Activity Log</h1>
            <div class="row">
           
        
                
            </div>

        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
 
          <div class="card-body">
              
            <div class="table-responsive">
               @foreach ($activitys as $activity)
               
               <p>{{$activity->username}} user {{$activity->action}} by {{$activity->rolename}}</p>
               
               @endforeach
            </div>
        
         </div>
           
        </div>

    </div>
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
