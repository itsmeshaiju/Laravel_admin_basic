<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="{{ asset('assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">{{env('APP_NAME')}}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div> -->

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{route('dashboard')}}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>



        <li class="nav-item 
          {{ request()->routeIs('tag.*') || request()->routeIs('category.*') ||  request()->routeIs('plan.*')  ? ' menu-is-opening menu-open' : '' }}
          ">
          <a href="#" class="nav-link 
            nav-link   {{ request()->routeIs('tag.*') ||  request()->routeIs('category.*') ||  request()->routeIs('plan.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-database"></i>
            <p>
              Master Managment
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('tag.index') }}" class="nav-link  
                {{ request()->routeIs('tag.*')  ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Tag </p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('category.index') }}" class="nav-link  
                {{ request()->routeIs('category.*')  ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Category </p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('plan.index') }}" class="nav-link  
                {{ request()->routeIs('plan.*')  ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Plan</p>
              </a>
            </li>
          </ul>

          
        </li>


        
        <li class="nav-item 
          {{ request()->routeIs('users.*')  || 
          request()->routeIs('permission.*') ||
          request()->routeIs('roles.*') ?
           ' menu-is-opening menu-open' : '' }}
          ">
          <a href="#" class="nav-link 
            nav-link   {{ request()->routeIs('posts.*') ||request()->routeIs('posts.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user"></i>
            <p>
              User Managment
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('users.index') }}" class="nav-link  
                {{ request()->routeIs('users.*')  ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Users</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('roles.index') }}" class="nav-link
                {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Role</p>
              </a>
              
            </li>
            <li class="nav-item">
              <a href="{{ route('permission.index') }}" class="nav-link
                {{ request()->routeIs('permission.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Permission</p>
              </a>
              
            </li>
            
          </ul>
        </li>

        <li class="nav-item 
          {{ request()->routeIs('userlog.*')  ? ' menu-is-opening menu-open' : '' }}
          ">
          <a href="#" class="nav-link 
            nav-link   {{ request()->routeIs('userlog.*') ? 'active' : '' }}">
            <i class="nav-icon fa fa-tasks"></i>
            <p>
              Activity Management
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('userlog.index') }}" class="nav-link  
                {{ request()->routeIs('userlog.*')  ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Logs</p>
              </a>
            </li>
           

          </ul>
        </li>

        
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>