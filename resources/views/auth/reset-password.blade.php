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
                <form action="{{ route("password.update") }}" method="post">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <div class="input-box">
                        <input type="text" name="email" value="{{ old('email', $request->email) }}" class="input-field"
                            placeholder="Isi dengan Email"">
                    <i class=" bx bx-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" name="password" class="input-field">
                        <i class="bx bx-lock-alt"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" name="password_confirmation" class="input-field">
                        <i class="bx bx-lock-alt"></i>
                    </div>
                    <div class="input-box">
                        <input type="submit" class="submit" value="Reset Password">
                    </div>
                </form>
            </div>
                    <div class="d-flex flex-column-reverse" style="margin-top: 450px; color: white;">
        <x-validation-errors class="mb-4 d-flex flex-column align-items-center" style="color: white;" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif
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
</html>