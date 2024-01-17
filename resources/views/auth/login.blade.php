<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset ( 'lte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset ( 'lte/dist/css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>SI-POLAR</title>
</head>
<body>
    <div class="wrapper" style="flex-direction: column;">
        <nav class="nav">
            <div class="nav-logo">
                <p><b>SIP-POLAR</b></p>
            </div>
            <div class="nav-button">
                <button class="btn white-btn" id="loginBtn" onclick="login()">Sign In</button>
                <button class="btn" id="registerBtn" onclick="register()">Sign Up</button>
            </div>
            <div class="nav-menu-btn">
                <i class="bx bx-menu" onclick="myMenuFunction()"></i>
            </div>
        </nav>


        <!----------------------------- Form box ----------------------------------->
        <div class="form-box">
            <!------------------- login form -------------------------->
            <div class="login-container" id="login">
                <div class="top">
                    <span>Belum Punya Akun? <a href="#" onclick="register()">Sing up</a></span>
                    <header>Login</header>
                </div>

                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="input-box">
                        <input type="text" name="email" value="{{ old('email') }}" class="input-field"
                            placeholder="Isi dengan Email"">
                <i class=" bx bx-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" name="password" class="input-field" placeholder="Isi dengan Password">
                        <i class="bx bx-lock-alt"></i>
                    </div>
                    <div class="input-box">
                        <input type="submit" class="submit" value="Sign In">
                    </div>
                    <div class="two-col">
                        <div class="one">
                            <input type="checkbox" name="remember" id="login-check">
                            <label for="login-check"> Remember Me</label>
                        </div>
                        <div class="two">
                            <label><a href="{{ route('password.request') }}">Forgot password?</a></label>
                        </div>
                    </div>
                </form>
            </div>

            <!------------------- registration form -------------------------->
            <div class="register-container" id="register">
                <div class="top">
                    <span>Sudah Punya Akun? <a href="#" onclick="login()">Login</a></span>
                    <header>Sign Up</header>
                </div>
                <form action="{{ route ('register') }}" method="post">
                    @csrf
                    <div class="input-box">
                        <div class="input-box">
                            <input type="text" name="name" value="{{ old('name') }}" class="input-field"
                                placeholder="Username" required>
                            <i class="bx bx-user"></i>
                        </div>
                    </div>
                    <div class="input-box">
                        <input type="text" name="email" value="{{ old('email') }}" class="input-field"
                            placeholder="Email" required>
                        <i class="bx bx-envelope"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" name="password" class="input-field" required placeholder="Password">
                        <i class="bx bx-lock-alt"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" name="password_confirmation" required class="input-field"
                            placeholder="Password Confirmation">
                        <i class="bx bx-lock-alt"></i>
                    </div>
                    <div class="input-box">
                        <input type="submit" class="submit" value="Register">
                    </div>
            </div>
        </div>
    </div>
    </div>

    @if($errors->any())
    <script>
        var errorMessages = '<ul>';
        @foreach($errors->all() as $error)
        errorMessages += '<li>{{ $error }}</li>';
        @endforeach
        errorMessages += '</ul>';

        Swal.fire({
            title: "Error!",
            html: errorMessages,
            icon: "error",
        });
    </script>
    @endif



    <script>
        function myMenuFunction() {
            var i = document.getElementById("navMenu");

            if (i.className === "nav-menu") {
                i.className += " responsive";
            } else {
                i.className = "nav-menu";
            }
        }
    </script>

    <script>
        var a = document.getElementById("loginBtn");
        var b = document.getElementById("registerBtn");
        var x = document.getElementById("login");
        var y = document.getElementById("register");

        function login() {
            x.style.left = "4px";
            y.style.right = "-520px";
            a.className += " white-btn";
            b.className = "btn";
            x.style.opacity = 1;
            y.style.opacity = 0;
        }

        function register() {
            x.style.left = "-510px";
            y.style.right = "5px";
            a.className = "btn";
            b.className += " white-btn";
            x.style.opacity = 0;
            y.style.opacity = 1;
        }
    </script>


    @if($message = Session::get('failed'))
    <script>
        Swal.fire('{{$message}}');
    </script>
    @endif

    @if($message = Session::get('Succes'))
    <script>
        Swal.fire('{{$message}}');
    </script>
    @endif

</body>
</html>