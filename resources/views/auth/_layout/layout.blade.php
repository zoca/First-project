<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <title>
            @if(\View::hasSection('head_title'))
            @yield('head_title')
            -
            @endif
            {{config('app.name')}}
        </title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <meta name="description" content="{{config('app.description')}}" />
        <meta content="Cubes d.o.o." name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('/assets/images/favicon.ico')}}">

        <!-- App css -->
        <link href="{{asset('/theme/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('/theme/assets/css/metismenu.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('/theme/assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('/theme/assets/css/style.css')}}" rel="stylesheet" type="text/css" />

        <link href="{{asset('/theme/plugins/bootstrap-select/css/bootstrap-select.min.css')}}" rel="stylesheet" />

        @stack('head_links')

        <script src="{{asset('/theme/assets/js/modernizr.min.js')}}"></script>

        @stack('head_scripts')

    </head>


    <body class="bg-transparent">

        <!-- HOME -->
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">

                        <div class="wrapper-page">

                            <div class="m-t-40 account-pages">
                                <div class="text-center account-logo-box">
                                    <h2 class="text-uppercase">
                                        <a href="{{url('/')}}" class="text-success">
                                            <span><img src="{{asset('/theme/assets/images/logo_dark.png')}}" alt="" height="30"></span>
                                        </a>
                                    </h2>
                                    <!--<h4 class="text-uppercase font-bold m-b-0">Sign In</h4>-->
                                </div>
                                <div class="account-content">
                                        @yield('content')
                                </div>
                            </div>
                            <!-- end card-box-->
                        </div>
                        <!-- end wrapper -->

                    </div>
                </div>
            </div>
          </section>
          <!-- END HOME -->



        <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="{{asset('/theme/assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('/theme/assets/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('/theme/assets/js/metisMenu.min.js')}}"></script>
        <script src="{{asset('/theme/assets/js/waves.js')}}"></script>
        <script src="{{asset('/theme/assets/js/jquery.slimscroll.js')}}"></script>
        <script src="{{asset('/theme/plugins/bootstrap-select/js/bootstrap-select.min.js')}}"></script>

        <!-- App js -->
        <script src="{{asset('/theme/assets/js/jquery.core.js')}}"></script>
        <script src="{{asset('/theme/assets/js/jquery.app.js')}}"></script>

        @stack('footer_scripts')
    </body>
</html>
