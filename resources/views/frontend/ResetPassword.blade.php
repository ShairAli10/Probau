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
    <img src="{{ 'frontend/media/loginbg1.png' }}" class="back-img" alt="">
    <div class="container align-center d-flex justify-content-center align-items-center">


        <form class="shadow-sm rounded" id="loginForm"
            style="border-radius: 20px; border: 1px solid #DBDFE9; background: #FFF; padding:25px 40px; width: 505px;">

            <div class="row mt-5  p-4 parent">
                <div style="display: flex;flex-direction: column;justify-content: center;align-items: center;gap: 24px;">
                    <div class="logo">
                        <div style="text-align: center">
                            <img alt="Logo " style="align-items: center;"
                                src="{{ 'frontend/media/logos/loginLogo.png' }}" class="h-55px img-fluid ">
                        </div>
                        <div class="welcome fw-bolder text-dark">Reset Password</div>
                        <div class="message">Enter your new password to continue to your account</div>
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
                    <label class="fs-6 mt-5 form-label fw-bolder text-dark">New Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control form-control border p-5" name="password1"
                            id="password1" placeholder="Enter new password" value="{{ old('password') }}" required>
                        <button type="button" id="togglePassword1" class="btn btn-outline-secondary">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <span class="text-danger" id="password1Error"></span>
                    <!-- Placeholder for password1 error message -->
                </div>
                <div class="mb-5">
                    <label class="fs-6 form-label fw-bolder text-dark">Retype New Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control form-control border p-5" name="password2"
                            id="password2" placeholder="Enter new password" value="{{ old('password') }}" required>
                        <button type="button" id="togglePassword2" class="btn btn-outline-secondary">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <span class="text-danger" id="password2Error"></span>
                    <!-- Placeholder for password2 error message -->
                </div>
                <!--end::Input group-->
                <div class="d-flex justify-content-between">
                    <div>

                    </div>
                    <div class="fs-5 fw-bolder text-dark">

                    </div>
                </div>
                <!--begin::Action-->
                <div class="d-flex align-items-center justify-content-end pt-7">
                    <button type="submit" class="btn btn-danger w-100 p-5 text-uppercase resetButton" id="btnLogin"
                        style="background-color:#F70D1A;">Reset
                        Password
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
                event.preventDefault();

                $('#password1Error').text('');
                $('#password2Error').text('');

                var password = $('#password1').val();
                var confirm_password = $('#password2').val();

                if (!password) {
                    $('#password1Error').text('New password is required.');
                    return;
                }

                if (!confirm_password) {
                    $('#password2Error').text('Confirm password is required.');
                    return;
                }

                // Make the AJAX request
                $.ajax({
                    url: 'ResetPassword',
                    type: 'POST',
                    data: {
                        password: password,
                        confirm_password: confirm_password,
                    },
                    success: function(response) {
                        var data = $.parseJSON(response);
                        if (data.status) {
                            window.location.href = '/';
                        } else {
                            // Display validation errors if any
                            var errors = data.message;
                            if (errors.password) {
                                $('#password1Error').text(errors.password[0]);
                            }
                            if (errors.confirm_password) {
                                $('#password2Error').text(errors.confirm_password[0]);
                            }
                        }
                        $("#btnLogin").removeAttr('disabled');
                    },
                    error: function(xhr, status, error) {
                        swal("Error", "your new password and confirm password are not matched",
                            "error");
                        $("#btnLogin").removeAttr('disabled');
                    }
                });
            });

            const togglePassword1 = document.getElementById('togglePassword1');
            const password1 = document.getElementById('password1');

            togglePassword1.addEventListener('click', function() {
                const type = password1.getAttribute('type') === 'password' ? 'text' : 'password';
                password1.setAttribute('type', type);
            });

            const togglePassword2 = document.getElementById('togglePassword2');
            const password2 = document.getElementById('password2');

            togglePassword2.addEventListener('click', function() {
                const type = password2.getAttribute('type') === 'password' ? 'text' : 'password';
                password2.setAttribute('type', type);
            });

        });
    </script>
</body>

</html>
