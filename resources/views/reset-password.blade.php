<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="{{asset('assets/css/main/app.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/pages/auth.css')}}">
    <link rel="shortcut icon" href="{{asset('assets/images/logo/favicon.svg')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset('assets/images/logo/favicon.png')}}" type="image/png">
</head>

<body>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo mb-5">
                        <a href="#"><img src="{{asset('assets/images/logo/logo.svg')}}" alt="Logo"></a>
                    </div>

                    <h1 class="auth-title">Reset Password</h1>

                    @if ($errors->any())
                        <div class="card-body pt-0">
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible show fade">
                                    <i class="bi bi-file-excel"></i> {{ $error }}

                                    <button type="button" class="btn-close btn-close-session" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.store') }}" id="reset_password_form">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="username" value="{{ $username }}">

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" placeholder="New password" name="password" required>

                            <div class="form-control-icon">
                                <i class="bi bi-lock"></i>
                            </div>
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" placeholder="Confirm password" name="password_confirmation" required>

                            <div class="form-control-icon">
                                <i class="bi bi-lock"></i>
                            </div>
                        </div>

                        <button class="btn btn-primary btn-block btn-lg shadow-lg mb-3" id="reset_password_submit" onclick='preventDoubleClick("reset_password_form", "reset_password_submit")' type="submit">Reset Password</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">

                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('assets/js/bootstrap.js')}}"></script>
    <script src="{{asset('assets/extensions/jquery/jquery.min.js')}}"></script>

    <script>
        // Set time out error
        @error('error')
            setTimeout(() => {
                $('.btn-close-session').trigger('click')
            }, 5000);
        @enderror

        // Function for prevent double click
        function preventDoubleClick(id_form, id_button){
            console.log(id_button)
            $('#'+id_button).attr('disabled', true)
            $('#'+id_form).submit()
        }
    </script>
</body>

</html>
