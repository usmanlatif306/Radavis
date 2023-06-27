<ul class="navbar-nav sidebar sidebar-dark " id="accordionSidebar" style="background-color: rgb(0, 67, 135) !important;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <img class="img-fluid" src="http://radavisdispatch.com/rad-logo-2.png" />
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <!-- <hr class="sidebar-divider"> -->

   

    @hasrole('Admin')

    <!-- Divider -->
    <?php
    /*<hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link" href="{{ route('dispatch.index') }}">
            <i class="fas fa-fw fa-fighter-jet"></i>
            <span>Dispatch</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">*/
    ?>
    @endhasrole

    @hasrole('Admin')
    <hr class="sidebar-divider d-none d-md-block">


    <li class="nav-item">
        <a class="nav-link" href="{{ route('dispatch.searchview') }}">
            <i class="fas fa-fw fa-search"></i>
            <span>Dispatch</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    @endhasrole

    <!-- @hasrole('Admin')



    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
            aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Masters</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Role & Permissions</h6>
                <a class="collapse-item" href="{{ route('roles.index') }}">Roles</a>
                <a class="collapse-item" href="{{ route('permissions.index') }}">Permissions</a>
            </div>
        </div>
    </li>

     Divider
    <hr class="sidebar-divider d-none d-md-block">
    @endhasrole -->


    @hasrole('Admin')



    <li class="nav-item">
        <a class="nav-link" href="{{ route('commoditie.index') }}">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>Commodities</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    @endhasrole

    @hasrole('Admin')



    <li class="nav-item">
        <a class="nav-link" href="{{ route('supplier.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Suppliers</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    @endhasrole

    @hasrole('Admin')



    <li class="nav-item">
        <a class="nav-link" href="{{ route('exit.index') }}">
            <i class="fas fa-fw fa-torii-gate"></i>
            <span>Exit</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    @endhasrole

    @hasrole('Admin')



    <li class="nav-item">
        <a class="nav-link" href="{{ route('via.index') }}">
            <i class="fas fa-fw fa-truck"></i>
            <span>Trucks</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    @endhasrole


    @hasrole('Admin')


    <li class="nav-item">
        <a class="nav-link" href="{{ route('destination.index') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Destination</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    @endhasrole

    @hasrole('Admin')


   
    <li class="nav-item">
        <a class="nav-link" href="{{ route('rate.index') }}">
            <i class="fas fa-fw fa-dollar-sign"></i>
            <span>Rates</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    @endhasrole
    @hasrole('Admin')

    <li class="nav-item">
        <a class="nav-link" href="{{ route('config.index') }}">
            <i class="fas fa-fw fa-cog"></i>
            <span>Config</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    @endhasrole


    @hasrole('salesman')

    <li class="nav-item">
        <a class="nav-link" href="{{ route('dispatch.index') }}">
            <i class="fas fa-fw fa-fighter-jet"></i>
            <span>Dispatch</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dispatch.searchview') }}">
            <i class="fas fa-fw fa-search"></i>
            <span>Search Dispatch</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    @endhasrole
    @hasrole('Clerical')

    <li class="nav-item">
        <a class="nav-link" href="{{ route('dispatch.index') }}">
            <i class="fas fa-fw fa-fighter-jet"></i>
            <span>Dispatch</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dispatch.searchview') }}">
            <i class="fas fa-fw fa-search"></i>
            <span>Search Dispatch</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    @endhasrole

    @hasrole('Admin')

        <div class="sidebar-heading">
            Management
        </div>


        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-user-alt"></i>
                <span>User Management</span>
            </a>
            <ul class="navbar-nav sidebar-dark">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.index') }}">
                        <i class="fas fa-list-alt"></i>
                        <span>List</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.create') }}">
                        <i class="fas fa-plus-circle"></i>
                        <span>Add New</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.import') }}">
                        <i class="fas fa-upload"></i>
                        <span>Import Data</span>
                    </a>
                </li>
            </ul>
        </li>
        <hr class="">
    @endhasrole

    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>