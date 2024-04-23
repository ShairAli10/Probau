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

    .custom-input:focus {
        border-color: #ff2600;
        /* Change this to your desired primary color code */
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        /* Optional: Add a subtle box shadow when focused */
    }

    .login-right {
        height: 100vh;
    }

    @media only screen and (max-width: 1400px) {
        .login-right {
            height: 120vh;
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    @keyframes changeColor {
        0% {
            color: red;
        }

        25% {
            color: yellow;
        }

        50% {
            color: green;
        }

        75% {
            color: blue;
        }

        100% {
            color: red;
        }
    }

    .dynamic-color-spinner {
        animation: spin 1s linear infinite, changeColor 2s infinite;
    }


    .btn:not(.btn-outline):not(.btn-dashed):not(.border-hover):not(.border-active):not(.btn-flush):not(.btn-icon) {
        background-color: transparent;
        border: 1px solid;
    }
</style>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body>
    <img src="{{ 'frontend/media/loginbg1.png' }}" class="back-img" alt="">
    <div class="container align-center d-flex justify-content-center align-items-center">


        <form class="shadow-sm rounded" id="loginForm"
            style="border-radius: 20px; border: 1px solid #DBDFE9; background: #FFF; padding:25px 40px; width: 505px;">
            <div class="row mt-5  p-4 parent">
                <div
                    style="display: flex;flex-direction: column;justify-content: center;align-items: center;gap: 24px;">
                    <div class="logo">
                        <div style="text-align: center">
                            <img alt="Logo " style="align-items: center;"
                                src="{{ '/frontend/media/logos/loginLogo.png' }}" class="h-55px img-fluid ">
                        </div>
                        <div class="welcome fw-bolder text-dark">Forget Password</div>
                        <div class="message">Enter your email so that we can send you Reset password link</div>
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
                    <span class="text-danger error-message"></span>

                </div>
                <!--end::Input group-->
                <div class="d-flex justify-content-end align-items-center">
                    <div id="loader" style="display:none;" class="mr-5 me-3">
                        <div class="spinner-border spinner-border dynamic-color-spinner" role="status"></div>
                    </div>
                    <div class="fs-5 fw-bolder text-dark">
                        <a id="sendOtpBtn" class="link-danger fw-bolder cursor-pointer">
                            Send OTP
                        </a>
                    </div>
                </div>

                <div class="mb-5 pt-4" style="">
                    <div id="otp" class="inputs d-flex flex-row justify-content-center mt">
                        <input class="m-4 text-center form-control rounded custom-input" type="text" id="first"
                            maxlength="1" autocomplete="off" />
                        <input class="m-4 text-center form-control rounded custom-input" type="text" id="second"
                            maxlength="1" autocomplete="off" />
                        <input class="m-4 text-center form-control rounded custom-input" type="text" id="third"
                            maxlength="1" autocomplete="off" />
                        <input class="m-4 text-center form-control rounded custom-input" type="text" id="fourth"
                            maxlength="1" autocomplete="off" />
                    </div>
                </div>
                <!--begin::Action-->
                <div class="d-flex align-items-center justify-content-end ">
                    <button type="submit" class="btn btn-danger w-100 p-5 text-uppercase" id="nextBtn"
                        style="background-color:#F70D1A;">Next
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
        function showError(message) {
            // Show error message under the input field
            $(".error-message").text(message);
        }
        $(document).ready(function() {
            $("#sendOtpBtn").click(function() {
                var email = $("#email").val();
                if (!email) {
                    showError("Email address is required!");
                    return;
                }
                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    showError("Invalid email format! Please enter a valid email address.");
                    return;
                }

                $("#loader").show();
                $.ajax({
                    type: "POST",
                    url: "SendOtp",
                    data: {
                        email: email
                    },
                    success: function(response) {
                        $("#loader").hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'OTP sent successfully!'
                        });
                    },
                    error: function(xhr, status, error) {
                        $("#loader").hide();
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to send OTP. Please try again later.'
                        });
                    }
                });
            });

            function OTPInput() {
                const inputs = document.querySelectorAll('#otp > *[id]');
                for (let i = 0; i < inputs.length; i++) {
                    inputs[i].addEventListener('keydown', function(event) {
                        if (event.key === "Backspace") {
                            inputs[i].value = '';
                            if (i !== 0) inputs[i - 1].focus();
                        } else {
                            if (i === inputs.length - 1 && inputs[i].value !== '') {
                                return true;
                            } else if (event.keyCode > 47 && event.keyCode < 58) {
                                inputs[i].value = event.key;
                                if (i !== inputs.length - 1) inputs[i + 1].focus();
                                event.preventDefault();
                            } else if (event.keyCode > 64 && event.keyCode < 91) {
                                inputs[i].value = String.fromCharCode(event.keyCode);
                                if (i !== inputs.length - 1) inputs[i + 1].focus();
                                event.preventDefault();
                            }
                        }
                    });
                }
            }
            OTPInput();
            // Handle form submission for OTP verification
            $("#loginForm").submit(function(event) {
                event.preventDefault();

                const otpCode = $("#first").val() + $("#second").val() + $("#third").val() + $("#fourth")
                    .val();

                $.ajax({
                    type: "POST",
                    url: "VerifyOtp",
                    data: {
                        email: $("#email").val(),
                        otp: otpCode
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'OTP verified successfully!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href =
                                    "ChangePassword";
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Please Enter valid OTP.'
                        });
                    }
                });
            });
        });
    </script>


</body>

</html>
