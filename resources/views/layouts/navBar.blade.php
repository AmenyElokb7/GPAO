<script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->

<!-- inject:js -->
<link rel="stylesheet" href="../../assets/vendors/mdi/css/materialdesignicons.min.css">
<link rel="stylesheet" href="../../assets/vendors/css/vendor.bundle.base.css">
<!-- endinject -->

<!-- Layout styles -->
<link rel="stylesheet" href="../../assets/css/style.css">
<!-- End layout styles -->

<link rel="shortcut icon" href="../../assets/images/favicon.ico" />
</head>
<script src="../../assets/js/hoverable-collapse.js"></script>
<script src="../../assets/js/misc.js"></script>
<!-- endinject -->
<!-- Custom js for this page -->
<script src="../../assets/js/chart.js"></script>
<nav class="sidebar sidebar-offcanvas navbar-expand-lg" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">

            <div class="nav-profile-text d-flex flex-column">
                <span class="font-weight-bold mb-2">{{ Auth::user()->name }}</span>
                <span class="text-secondary text-small">{{ Auth::user()->role }}</span>
            </div>

        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('home') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="true"
                aria-controls="ui-basic">
                <span class="menu-title">Products</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ url('products') }}">Add Product</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('units') }}">Units</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('tasks') }}">
                <span class="menu-title">Tasks</span>
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic2" role="button" aria-expanded="false"
                aria-controls="ui-basic">
                <span class="menu-title">Projects</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-chart-bar menu-icon "></i>
            </a>
            <div class="collapse" id="ui-basic2">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ url('/') }}">Add Project</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('/search') }}">Search Project</a></li>
                </ul>
            </div>
        </li>
        <!-- <li class="nav-item"> <a class="nav-link" href="/login">Search Project</a></li> -->

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic1" role="button" aria-expanded="false"
                aria-controls="ui-basic">
                <span class="menu-title">Users</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-contacts menu-icon"></i>
            </a>
            <div class="collapse" id="ui-basic1">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ url('users') }}">Add User</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('posts') }}">Add Post</a></li>
                </ul>
            </div>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic1" role="button" aria-expanded="false"
                aria-controls="ui-basic">
                <span class="menu-title">Tasks</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-contacts menu-icon"></i>
            </a>
            <div class="collapse" id="ui-basic1">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('Taches') }}">Tasks</a></li>
                </ul>
            </div>
        </li> --}}
    </ul>
</nav>
