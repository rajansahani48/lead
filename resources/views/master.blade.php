<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    @if (auth()->user()->role=="admin")
    <title>Dashboard -Admin</title>
    @else
    <title>Dashboard -Telecaller</title>
    @endif
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <style>
        table {
            margin: 20px;
        }

        form {
            margin: 20px;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    @include('header')

    <div id="layoutSidenav">
        @include('sidenav')
        <div id="layoutSidenav_content">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            @if (session('messageUpdated'))
                <div class="alert alert-success">
                    {{ session('messageUpdated') }}
                </div>
            @endif
            @if (session('passwordChange'))
                <div class="alert alert-success">
                    {{ session('passwordChange') }}
                </div>
            @endif
            @if (session('passwordWarning'))
                <div class="alert alert-danger">
                    {{ session('passwordWarning') }}
                </div>
            @endif
            @if (session('ProfileUpdateMessage'))
                <div class="alert alert-success">
                    {{ session('ProfileUpdateMessage') }}
                </div>
            @endif

            @if (session('msgUserExists'))
                <div class="alert alert-danger">
                    {{ session('msgUserExists') }}
                </div>
            @endif
            @if (session('validValueValidation'))
                <div class="alert alert-danger">
                    {{ session('validValueValidation') }}
                </div>
            @endif
            @yield('main-content')
            @include('footer')
        </div>
    </div>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').hide('slow');
            }, 1500);
        });
    </script>
</body>

</html>
