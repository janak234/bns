<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="background-image: linear-gradient(to bottom, #236b2b, #387c38, #66a266, #f7ee23) !important; ">

    <!-- Sidebar - Brand -->
    <br>
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon">
        <img style="width:90%" src="{{asset('admin/img/logo_bns.png')}}" alt="alternate-text">
        </div>
        <!-- <div class="sidebar-brand-text mx-3">Tech-Admin</div>-->
    </a>

    
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('home') }}">
           <i class="fas fa-tachometer-alt" style="color: #f7ee23;"></i>
            <span>Dashboard</span></a>
    </li>



        <li class="nav-item">
        <a class="nav-link" href="{{ route('customer.index') }}" >
     <i class="	fas fa-users" style="color: #f7ee23;"></i>
            <span>Customers</span>
        </a>
    </li>
        <li class="nav-item">
        <a class="nav-link" href="{{ route('transaction.index') }}" >
            <i class="fas fa-money-bill-wave" style="color: #f7ee23;"></i>
            <span>Transactions</span>
        </a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">

     @hasrole('admin')
        <!-- Heading -->


        <div class="sidebar-heading">
            Admin Section
        </div>
           <li class="nav-item">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="f	fas fa-user-cog" style="color: #f7ee23;"> </i>
            <span>Users</span>
        </a>
    </li>
        <!-- Nav Item - Pages Collapse Menu -->
 

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
    @endhasrole

    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt" style="color: #f7ee23;"> </i>
            <span>Logout</span>
        </a>
    </li>
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>