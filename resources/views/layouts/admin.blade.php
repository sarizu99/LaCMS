<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    @prepend('stylesheets')
        <link href="{{ asset('node_modules\@fortawesome\fontawesome-free\css\all.min.css') }}" rel="stylesheet">
        <link href="{{ asset('node_modules\datatables.net-bs4\css\dataTables.bootstrap4.css') }}" rel="stylesheet">
    @endprepend
        
    @stack('stylesheets')
    <link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet">
</head>

<body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

        <a class="navbar-brand mr-1" target="_blank" href="{{ url('/') }}">{{ \App\SiteSetting::first()->name }}</a>

        <!-- Navbar -->
        <ul class="navbar-nav ml-auto mr-0 my-2 my-md-0">
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    Hello, {{ Auth::user()->name }}! <i class="fa fa-caret-down ml-2" aria-hidden="true"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
                </div>
            </li>
        </ul>

    </nav>

    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="sidebar navbar-nav">
            @component('components.nav-item', [
                'url'   => 'admin',
                'icon'  => 'thumbtack',
                'text'  => 'Post'
            ])
            @endcomponent
            
            @if (Auth::user()->is_admin)
                @component('components.nav-item', [
                    'icon'  => 'th-large',
                    'url'   => '/admin/category',
                    'text'  => 'Category'
                ])
                @endcomponent

                @component('components.nav-item', [
                    'icon'  => 'user',
                    'url'   => '/admin/users',
                    'text'  => 'Users'
                ])
                @endcomponent
    
                @component('components.nav-item', [
                    'icon'  => 'cog',
                    'url'   => '/admin/settings/general',
                    'text'  => 'Settings',
                    'dropdown' => [
                        [
                            'url' => '/admin/settings/general',
                            'text' => 'General'
                        ],
                        [
                            'url' => '/admin/settings/account',
                            'text' => 'Account'
                        ],
                    ]
                ])
                @endcomponent
            @endif

            @unless (Auth::user()->is_admin)
                @component('components.nav-item', [
                    'icon'  => 'cog',
                    'url'   => '/admin/settings/account',
                    'text'  => 'Settings'
                ])
                @endcomponent
            @endunless
        </ul>

        <div id="content-wrapper">

            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-name">@yield('title')</h1>
                    </div>
                </div>

                @yield('content')

                <div class="row credit">
                    <div class="col-12">
                        <footer class="footer">
                            <div class="container my-auto">
                                <div class="copyright text-center my-auto">
                                    <span>Copyright © {{ \App\SiteSetting::first()->name }} {{ \Carbon\Carbon::now()->year }}</span>
                                </div>
                            </div>
                        </footer>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @prepend('scripts')
        <script src="{{ asset('node_modules\jquery\dist\jquery.min.js') }}"></script>
        <script src="{{ asset('node_modules\bootstrap\dist\js\bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('node_modules\jquery-easing\dist\jquery.easing.1.3.umd.min.js') }}"></script>
    @endprepend
    
    @stack('scripts')
    <script src="{{ asset('js/sb-admin.js') }}"></script>
</body>

</html>