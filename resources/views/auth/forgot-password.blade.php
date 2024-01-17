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
    <div class="wrapper  ">
        <nav class="nav">
            <div class="nav-logo">
                <p><b>SIP-POLAR</b></p>
            </div>
        </nav>


        <!----------------------------- Form box ----------------------------------->
        <div class="form-box">
            <div class="login-container" id="login">
                <h3 style="text-align: center; color: white; margin-bottom: 20px;">
                    Form Forgot Password
                </h3>
                <form action="{{ route("password.email") }}" method="post">
                    @csrf
                    <div class="input-box">
                        <input type="text" name="email" value="{{ old('email') }}" class="input-field"
                            placeholder="Isi dengan Email"">
                    <i class=" bx bx-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="submit" class="submit" value="Request Forgot Password">
                    </div>
                </form>
            </div>
             
        </div>
    </div>
</body>
@if(session('status'))
<script>
    Swal.fire({
        title: "Success!",
        text: `{{ session('status') }}`,
        icon: "success",
    });
</script>
@endif
</html>