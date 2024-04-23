@include('frontend.layout.header')
<style>
    .back-img {
        position: absolute;
        top: 0%;
        left: 0%;
        width: 100%;
        height: 100vh;
        z-index: -1;
    }

    .container {
        height: 100%;
        display: flex;
        align-items: center;
    }

    .welcome {
        color: #071437;
        text-align: center;
        font-family: Trip Sans;
        font-size: 25px;
        font-style: normal;
        font-weight: 200;
        line-height: 31.2px;
        padding-top: 25px;
        /* 124.8% */
    }

    .message {
        color: #7B849A;
        text-align: center;
        font-family: Trip Sans;
        font-size: 17px;
        font-style: normal;
        font-weight: 400;
        line-height: 20.962px;
        padding-top: 10px;
        /* 116.458% */
        /* 150% */
    }

    .btn:not(.btn-outline):not(.btn-dashed):not(.border-hover):not(.border-active):not(.btn-flush):not(.btn-icon) {
        background-color: transparent;
        border: 1px solid;
    }
</style>

<body>
    <img src="{{ url('frontend/media/loginbg1.png') }}" class="back-img" alt="">
    <div class="container align-center d-flex justify-content-center align-items-center">


        <form class="shadow-sm rounded" id="loginForm"
            style="border-radius: 20px; border: 1px solid #DBDFE9; background: #FFF; padding:25px 40px; width: 505px;">
            <div class="row mt-5  p-4">
                <div style="display: flex;flex-direction: column;justify-content: center;align-items: center;gap: 24px;">
                    <div class="logo">
                        <div style="text-align: center">
                            <img alt="Logo " style="align-items: center;"
                                src="{{ url('/frontend/media/logos/loginLogo.png') }}" class="h-55px img-fluid ">
                        </div>
                        <div class="welcome fw-bolder text-dark">Sign In to your account</div>
                        <div class="message">Enter your email and password to continue to ProBau</div>
                    </div>
                </div>
                @if (Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                @if (Session::has('fail'))
                    <div class="alert alert-danger">{{ Session::get('fail') }}</div>
                @endif
                <!--begin::Input group-->
                <div class="mb-5 pt-4" style="">
                    <label class="fs-6 mt-5 form-label fw-bolder text-dark">Email Address</label>
                    <input type="email" class="form-control form-control  border border-primary p-5" name="email"
                        id="email" placeholder="Enter Email" autofocus required>
                    <span class="text-danger" id="emailError"></span>
                </div>
                <div class="mb-5">
                    <label class="fs-6 form-label fw-bolder text-dark">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control form-control  border border-primary  p-5"
                            name="password" id="password" placeholder="Enter your password"
                            value="{{ old('password') }}" required>
                        <button type="button" id="togglePassword" class="btn btn-outline-primary">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <span class="text-danger" id="passwordError"></span>
                </div>
                <!--end::Input group-->
                <div class="d-flex justify-content-between">
                    <div>
                    </div>
                    <div class="fs-5 fw-bolder text-dark">
                        <a href="{{ URL::to('ForgotPassword') }}" class="link-danger fw-bolder">
                            Forgot password?
                        </a>
                    </div>
                </div>
                <!--begin::Action-->
                <div class="d-flex align-items-center justify-content-end pt-7">
                    <button type="submit" class="btn btn-danger w-100 p-5 text-uppercase" id="btnLogin"
                        style="background-color:#F70D1A;">Sign In
                    </button>
                </div>
                <!--end::Action-->
        </form>
    </div>
    </div>
    <script src='https://cdn.firebase.com/js/client/2.2.1/firebase.js'></script>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="module">
        $(document).ready(function() {
            $('#btnLogin').on('click', function() {
                var email = $('#email').val();
                var password = $('#password').val();
                // Clear previous error messages
                $('#emailError').text('');
                $('#passwordError').text('');

                var isValid = true;

                if (!email) {
                    $('#emailError').text('Email is required.');
                    isValid = false;
                }

                if (!password) {
                    $('#passwordError').text('Password is required.');
                    isValid = false;
                }
                if (!isValid) {
                    return;
                }

                $('#btnLogin').attr('disabled', 'disabled');

                $.ajax({
                    url: 'loginn',
                    type: 'POST',
                    data: {
                        email: email,
                        password: password,
                    },
                    success: function(response) {
                        var data = $.parseJSON(response);
                        if (data.response == "success") {
                            swal({
                                title: "Success",
                                text: "Login successful",
                                icon: "success",
                                buttons: false,
                            });
                            window.location.href = 'Dashboard';
                        } else if (data.response == "error") {
                            swal("Login Failed", "Invalid email or password", "error").then(
                                function() {
                                    $('#btnLogin').removeAttr('disabled');
                                });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        swal("Error", "An error occurred while processing your request.",
                            "error").then(function() {
                            $('#btnLogin').removeAttr('disabled');
                        });
                    }
                });
            });

            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');

            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
            });
        });
    </script>
</body>

</html>
