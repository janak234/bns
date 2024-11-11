@extends('layouts.app')

@section('title', 'Customer List')

@section('content')


    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Transactions</h1>
            <div class="row">
           
        
                
            </div>

        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
 <form action="{{ route('transaction.search') }}" method="POST">
    @csrf
<div class="card-header py-3">
    <div class="row">
   
        <div class="col-md-4 text-md-left">
            <select class="form-control form-control-user" name="item" required>
                <option disabled>Search By</option>
                <option value="name" selected>Name</option>               
                <option value="company" @if(isset($item)) @if($item=='company') selected @endif @endif> Company</option>
                <option value="description" @if(isset($item)) @if($item=='description') selected @endif @endif> Description</option>        
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
          <a href="{{ route('transaction.index') }}" title="Clear Filter!" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                 X
            </a>
            @endif
        </div>
 
        <!--<div class="col-md-2 mt-2 mt-md-0 text-md-right">-->
        <!--    <a href="{{ route('transaction.create') }}" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm">-->
        <!--        <i class="fas fa-plus fa-sm"></i> Add New Transaction-->
        <!--    </a>-->
        <!--</div>-->
    </div>
</div>
</form>
          <div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                <th width="3%">ID</th>
                    <th width="10%">Date</th>
                    <th width="12%">Amount</th>
                    <th width="10%">Customer Name</th>
                    <th width="13%">Company Name</th>
                    <th width="5%">Status</th>
                    {{-- @hasanyrole('admin|supervisor')<th width="5%">Action</th> @endhasanyrole --}}
                </tr>
            </thead>
            <tbody>
            <?php $cnt =1; ?>
                @foreach ($users as $user)
                 
                            <tr @if($user->is_cheked == '1') style="font-weight: 900; background-color: #FFAFAF;"@endif>
                                <td>{{ $cnt++}} </td>
                                <td>{{ $user->date }}</td>
                                <td>{{ $user->amount }}</td>
                                <td>{{ $user->customer_fullname }}</td>
                                <td>{{ $user->compnyname }}</td>
                                <td>@if ($user->status == 0) Pending @elseif ($user->status == 1)   Approved  @endif</td>
                                {{-- @hasanyrole('admin|supervisor') <td style="display: flex">
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
         {{ $users->links() }}
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
