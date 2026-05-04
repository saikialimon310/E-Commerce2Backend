<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
  <div class="sidebar-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark">
      <a href="{{ route('home') }}" class="logo">
        <img
          src="{{ asset('assets/img/kaiadmin/logo_light.svg') }}"
          alt="logo"
          class="navbar-brand"
          height="20"
        />
      </a>

      <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar">
          <i class="gg-menu-right"></i>
        </button>
        <button class="btn btn-toggle sidenav-toggler">
          <i class="gg-menu-left"></i>
        </button>
      </div>
    </div>
    <!-- End Logo Header -->
  </div>

  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <ul class="nav nav-secondary">

        <!-- Dashboard -->
        <li class="nav-item">
          <a href="{{ route('home') }}">
            <i class="fas fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Management</h4>
        </li>

        <!-- Categories -->
        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#categoriesMenu">
            <i class="fas fa-layer-group"></i>
            <p>Categories</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="categoriesMenu">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{ route('categories.index') }}">
                  <span class="sub-item">All Categories</span>
                </a>
              </li>
              <li>
                <a href="{{ route('categories.create') }}">
                  <span class="sub-item">Add Category</span>
                </a>
              </li>
            </ul>
          </div>
        </li>

        <!-- Products -->
        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#productsMenu">
            <i class="fas fa-box"></i>
            <p>Products</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="productsMenu">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{ route('products.index') }}">
                  <span class="sub-item">All Products</span>
                </a>
              </li>
              <li>
                <a href="{{ route('products.create') }}">
                  <span class="sub-item">Add Product</span>
                </a>
              </li>
            </ul>
          </div>
        </li>

      
        <!-- Availabilities -->
        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#availabilityMenu">
            <i class="fas fa-pen-square"></i>
            <p>AvailableProduct</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="availabilityMenu">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{ route('available-products.index') }}">
                  <span class="sub-item">All Availabilities</span>
                </a>
              </li>
              <li>
                <a href="{{ route('available-products.create') }}">
                  <span class="sub-item">Add Availability</span>
                </a>
              </li>
            </ul>
          </div>
        </li>

        <!-- Users -->
        {{-- <li class="nav-item">
          <a data-bs-toggle="collapse" href="#usersMenu">
            <i class="fas fa-users"></i>
            <p>Users</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="usersMenu">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{ route('users.index') }}">
                  <span class="sub-item">All Users</span>
                </a>
              </li>
              <li>
                <a href="#">
                  <span class="sub-item">Add User</span>
                </a>
              </li>
            </ul>
          </div>
        </li> --}}

      </ul>
    </div>
  </div>
</div>
<!-- End Sidebar -->