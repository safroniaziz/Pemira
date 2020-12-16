<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
        <title>PEMIRA FMIPA | Login</title>
        <link rel="shortcut icon" href="{{ asset('assets/login/images/logo.png') }}">
        <link href="{{ asset('assets/login/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href=" {{ asset('assets/login/style_login.css') }} ">
        <link href="{{ asset('assets/login/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
	</head>
    
	<body style="background-image:linear-gradient( rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7) ), url('{{ asset("assets/login/images/background.png") }}')">
		<div id="particles-js">
            <div class="loginBox">
                <img src=" {{ asset('assets/login/images/logo.png') }} " class="user">
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block" style="font-size:13px;">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Perhatian:</strong> <i>{{ $message }}</i>
                    </div>
                    @else
                    <h6>Login Operator</h6>
                    <p style="text-align:center; margin-bottom:20px;">Pemilihan Raya Matematika & Ilmu Pengetahuan Alam </p>
                @endif
                <form method="post" action="{{ route('panda.login.post') }}">
                    @csrf
                    <p>NPM Mahasiswa</p>
                    <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <p>Password</p>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <button type="submit" name="submit" style="margin-bottom:10px;r"><i class="fa fa-sign-in"></i>&nbsp; Login</button>

                </form>
            </div>
        </div>
    </body>
    <script type="text/javascript" src=" {{ asset('assets/login/particles/particles.min.js') }} "></script>
    <script type="text/javascript" src=" {{ asset('assets/login/particles/app.js') }} "></script>
    <script>
        document.addEventListener('contextmenu', event => event.preventDefault());
    </script>
</html>