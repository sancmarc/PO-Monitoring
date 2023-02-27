<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard</title>

    @include('partials.header-link')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-secondary bg-gradient">
        <a class="navbar-brand ps-3" href="{{ route('admin.dashboard') }}">
            PO-Monitoring System
        </a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

        <ul class="navbar-nav d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>

    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link {{ (request()->is('admin/dashboard*')) ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <!-- <div class="sb-sidenav-menu-heading">Interface</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Layouts
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="layout-static.html">Static Navigation</a>
                                    <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Pages
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Authentication
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="login.html">Login</a>
                                            <a class="nav-link" href="register.html">Register</a>
                                            <a class="nav-link" href="password.html">Forgot Password</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Error
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="401.html">401 Page</a>
                                            <a class="nav-link" href="404.html">404 Page</a>
                                            <a class="nav-link" href="500.html">500 Page</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div> -->
                        <div class="sb-sidenav-menu-heading">Pages</div>
                        <a class="nav-link {{ (request()->is('admin/add-po*')) ? 'active' : '' }}" href="{{route('add.po')}}">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            PO-Monitor
                        </a>
                        <a class="nav-link {{ (request()->is('admin/billed-po*')) ? 'active' : '' }}" href="{{route('billed.list')}}">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            All Billed
                        </a>
                        <a class="nav-link collapsed {{ (request()->is('admin/biph*')) ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseBiph" aria-expanded="false" aria-controls="collapseBiph">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            BIPH Model
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseBiph" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{ (request()->is('admin/biph-po')) ? 'active' : '' }}" href="{{ route('biph.po') }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                    BIPH PO
                                </a>
                                <a class="nav-link {{ (request()->is('admin/biph')) ? 'active' : '' }}" href="{{ route('biph') }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                    BIPH BILLED
                                </a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed {{ (request()->is('admin/bivn*')) ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseBIVN" aria-expanded="false" aria-controls="collapseBIVN">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            BIVN Model
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseBIVN" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{ (request()->is('admin/bivn-po')) ? 'active' : '' }}" href="{{ route('bivn.po') }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                    BIVN PO
                                </a>
                                <a class="nav-link {{ (request()->is('admin/bivn')) ? 'active' : '' }}" href="{{ route('bivn') }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                    BIVN Billed
                                </a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed {{ (request()->is('admin/pantum*')) ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePantum" aria-expanded="false" aria-controls="collapsePantum">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Pantum Model
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePantum" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{ (request()->is('admin/pantum-po')) ? 'active' : '' }}" href="{{ route('pantum.po') }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                    Pantum PO
                                </a>
                                <a class="nav-link {{ (request()->is('admin/pantum')) ? 'active' : '' }}" href="{{ route('pantum') }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                    Pantum Billed
                                </a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed {{ (request()->is('admin/dcc-bc*')) ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseDccBc" aria-expanded="false" aria-controls="collapseDccBc">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            DCC-BC Model
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseDccBc" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{ (request()->is('admin/dcc-bc-po')) ? 'active' : '' }}" href="{{ route('dcc.bc.po') }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                    DCC-BC PO
                                </a>
                                <a class="nav-link {{ (request()->is('admin/dcc-bc')) ? 'active' : '' }}" href="{{ route('dcc.bc') }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                    DCC-BC Billed
                                </a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed {{ (request()->is('admin/dcc-bh*')) ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseDccBh" aria-expanded="false" aria-controls="collapseDccBh">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            DCC-BH Model
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseDccBh" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{ (request()->is('admin/dcc-bh-po')) ? 'active' : '' }}" href="{{ route('po.dcc.bh') }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                    DCC-BH PO
                                </a>
                                <a class="nav-link {{ (request()->is('admin/dcc-bh')) ? 'active' : '' }}" href="{{ route('dcc.bh') }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                    DCC-BH Billed
                                </a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed {{ (request()->is('admin/dcc-uhd*')) ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseDccUhd" aria-expanded="false" aria-controls="collapseDccUhd">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            DCC-UHD Model
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseDccUhd" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{ (request()->is('admin/dcc-uhd-po')) ? 'active' : '' }}" href="{{ route('po.dcc.uhd') }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                    DCC-UHD PO
                                </a>
                                <a class="nav-link {{ (request()->is('admin/dcc-uhd')) ? 'active' : '' }}" href="{{ route('dcc.uhd') }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                    DCC-UHD Billed
                                </a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed {{ (request()->is('admin/psnm*')) ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePsnm" aria-expanded="false" aria-controls="collapsePsnm">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            PSNM Model
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePsnm" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{ (request()->is('admin/psnm-po')) ? 'active' : '' }}" href="{{ route('po.psnm') }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                    PSNM PO
                                </a>
                                <a class="nav-link {{ (request()->is('admin/psnm')) ? 'active' : '' }}" href="{{ route('psnm') }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                    PSNM Billed
                                </a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed {{ (request()->is('admin/k1*')) ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#cololapseK1" aria-expanded="false" aria-controls="cololapseK1">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            K1 Model
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="cololapseK1" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{ (request()->is('admin/k1-po')) ? 'active' : '' }}" href="{{ route('po.k1') }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                    K1 PO
                                </a>
                                <a class="nav-link {{ (request()->is('admin/k1')) ? 'active' : '' }}" href="{{ route('k1') }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                    K1 Billed
                                </a>
                            </nav>
                        </div>



                        <a class="nav-link {{ (request()->is('admin/add-model*')) ? 'active' : '' }}" href="{{ route('add.model.products') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Add Model
                        </a>


                        <a class="nav-link {{ (request()->is('admin/product*')) ? 'active' : '' }}" href="{{ route('product') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Products
                        </a>

                        <a class="nav-link {{ (request()->is('admin/add-account*')) ? 'active' : '' }}" href="{{ route('admin.addAccount') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            Add Account
                        </a>


                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    @guest

                    @else
                    {{ Auth::user()->name }}
                    @endguest

                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main class="py-4">
                @yield('content')
            </main>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website {{ now()->year }}</div>
                            <div class="text-muted">Developer: Marco Polo Sanchez</div>

                        </div>
                    </div>
                </footer>
            </div>
  
            
        </div>
    </div>

</body>

</html>