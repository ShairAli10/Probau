<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request</title>
    <link rel="icon" type="image/x-icon" href="{{ url('frontend/media/PROBAU.jpg') }}">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./cotacus.css">
    <link href="https://fonts.googleapis.com/css2?family=Sharp+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<style>
    body {

        font-family: "Sharp Sans", sans-serif;
    }

    #errorAlert {
        transition: transform 0.5s ease-in-out;
    }

    .hidden {
        display: none;
    }


    #loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(251, 235, 235, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .loader-dots-container {
        display: flex;
    }

    .loader-dot {
        width: 12px;
        height: 12px;
        background-color: red;
        border-radius: 50%;
        margin: 0 6px;
        animation: bounce 1.5s infinite ease-in-out;
    }

    @keyframes bounce {

        0%,
        20%,
        50%,
        80%,
        100% {
            transform: translateY(0);
        }

        40% {
            transform: translateY(-15px);
        }

        60% {
            transform: translateY(-7px);
        }
    }

    .color {
        color: #FFF;
        text-align: center;
        /* font-family: Sharp Sans; */
        font-size: 40px;
        font-style: normal;
        line-height: normal;
        letter-spacing: -0.8px;
    }

    .color2 {
        color: #FFF;
        /* font-family: Sharp Sans; */
        font-size: 40px;
        font-style: normal;
        line-height: normal;
        letter-spacing: -0.8px;
    }

    .heading {
        color: #303030;
    }


    .foot-head {
        color: #303030;
        font-size: 28px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        letter-spacing: -0.56px;
    }

    @media screen and (max-width: 768px) {
        .logo-img {
            width: 50%;
            margin-left: 10px;

        }

        .left-sm {
            text-align: left;
        }

        .text-xl {
            font-size: 1rem;
        }

        .text-2xl {
            font-size: 1.2rem;
        }

        .text-4xl {
            font-size: 1.8rem;
        }
    }

    .textcolor {
        color: #3A3A3A;
    }

    .label-form {
        color: #303030;
        text-align: center;
        /* font-family: Sharp Sans; */
        font-size: 21.699px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        letter-spacing: -0.434px;
    }

    .input-form {
        width: 90%;
        padding: 20px;
        border-radius: 19.592px;
        background: #F8FAFB;
        color: #A0A0A0;
        font-size: 15.673px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        letter-spacing: -0.313px;
    }

    .btn-form {
        border-radius: 307.361px;
        border: 1.835px solid #F70D1A;
        background: #F70D1A;
        color: white;
        width: 90%;
        cursor: pointer;
        padding: 15px;
    }

    .text-form {
        width: 90%;
        padding: 20px;
        border-radius: 18.35px;
        background: #F8FAFB;
        color: #A0A0A0;
        font-size: 15.673px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        letter-spacing: -0.313px;
    }
</style>

<body>
    <div id="errorAlert" class="alert alert-danger alert-dismissible fade show hidden" role="alert">
        <strong>Error:</strong> An error apeared while submitting your request.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="main ">

        <div class="container mx-auto">
            <div class="logo mt-6">
                <img src="{{ url('frontend/media/loginLogo.png') }}" alt="">
            </div>
            <h1 class="text-center my-4 "
                style="
            color: #F70D1A;
            font-size: 32px;
            font-style: normal;
            font-weight: 600;
            line-height: 141.688%; /* 45.34px */">
                Konto löschen </h1>
            <p class=""
                style="color: #3A3A3A;
            text-align: center;
            font-size: 20px;
            font-style: normal;
            font-weight: 500;
            line-height: 31px; /* 155% */
            width: 90%;
            margin-left: 5%;
            ">
                Treten Sie mit uns bei ProBau in Kontakt für individuelle Unterstützung und schnelle Antworten. Ihre
                Anfragen sind uns wichtig, und wir sind hier, um Ihre Erfahrung außergewöhnlich zu gestalten.
            </p>
            <div class="flex mt-6 justify-center ">
                <p class="flex items-center mr-8">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50"
                        fill="none">
                        <path
                            d="M32.5939 26.5102L31.8349 27.265C31.8349 27.265 30.0305 29.059 25.1055 24.162C20.1805 19.2649 21.9848 17.4709 21.9848 17.4709L22.4629 16.9956C23.6404 15.8247 23.7515 13.9448 22.7241 12.5724L20.6224 9.76505C19.3508 8.06645 16.8936 7.84206 15.4361 9.2913L12.8201 11.8924C12.0974 12.611 11.6131 13.5426 11.6718 14.5759C11.8221 17.2196 13.0182 22.9077 19.6926 29.5442C26.7706 36.582 33.4117 36.8617 36.1275 36.6085C36.9865 36.5284 37.7335 36.0909 38.3355 35.4923L40.7031 33.1382C42.3013 31.5491 41.8507 28.8248 39.8059 27.7132L36.6217 25.9823C35.2791 25.2524 33.6433 25.4668 32.5939 26.5102Z"
                            fill="#F70D1A" />
                    </svg>
                    <span class="ml-4">+921-2345-6789</span>
                </p>

                <p class="flex items-center ml-8">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50"
                        fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M10.2856 13.6194C8.33301 15.572 8.33301 18.7147 8.33301 25.0001C8.33301 31.2855 8.33301 34.4282 10.2856 36.3808C12.2383 38.3334 15.3809 38.3334 21.6663 38.3334H28.333C34.6184 38.3334 37.7611 38.3334 39.7137 36.3808C41.6663 34.4282 41.6663 31.2855 41.6663 25.0001C41.6663 18.7147 41.6663 15.572 39.7137 13.6194C37.7611 11.6667 34.6184 11.6667 28.333 11.6667H21.6663C15.3809 11.6667 12.2383 11.6667 10.2856 13.6194ZM35.96 17.5332C36.4019 18.0635 36.3302 18.8517 35.7999 19.2937L32.1391 22.3444C30.6618 23.5755 29.4645 24.5733 28.4077 25.253C27.3069 25.961 26.2348 26.4082 24.9997 26.4082C23.7645 26.4082 22.6925 25.961 21.5916 25.253C20.5349 24.5733 19.3375 23.5755 17.8603 22.3444L14.1994 19.2937C13.6691 18.8517 13.5974 18.0635 14.0394 17.5332C14.4814 17.0028 15.2696 16.9312 15.7999 17.3731L19.3981 20.3716C20.953 21.6674 22.0326 22.5641 22.944 23.1503C23.8262 23.7177 24.4246 23.9082 24.9997 23.9082C25.5748 23.9082 26.1731 23.7177 27.0554 23.1503C27.9668 22.5641 29.0464 21.6674 30.6013 20.3716L34.1994 17.3731C34.7298 16.9312 35.518 17.0028 35.96 17.5332Z"
                            fill="#F70D1A" />
                    </svg>
                    <span class="ml-4">info@probau.com</span>
                </p>
            </div>
            <div class="flex items-center justify-center py-12 my-4">
                <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 gap-10 ">
                    <div class="">
                        <img style="height:97%; width:90%;" src="{{ url('frontend/media/form.png') }}" alt="">
                    </div>
                    <!-- 2nd -->
                    <div id="contactForm">

                        <div class="">
                            <label for="email" class="label-form">Email Address</label>
                            <br>
                            <input class="input-form mt-3 mb-6" type="email" name="email" id="email" required
                                placeholder="Enter your email">
                        </div>
                        <div class="">
                            <label for="reason" class="label-form">Reason</label>
                            <br>
                            <textarea class="text-form mt-3 mb-6" cols="30" rows="5" type="text" name="reason" id="reason"
                                required placeholder="Write a reason for account deletion"></textarea>
                        </div>
                        <button class="btn-form" onclick="submitForm()">Send</button>
                        <!-- Loader -->
                        <!-- Loader -->
                        <div id="loader" class="d-none">
                            <div class="loader-dots-container">
                                <div class="loader-dot"></div>
                                <div class="loader-dot"></div>
                                <div class="loader-dot"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <hr style="width:100%;text-align:left;margin-left:0;position: absolute; left:0px;">
            <h1 class="foot-head py-6">ProBau</h1>
            <div class="pb-4">
                <a href="{{ URL::to('Privacy') }}" class="textcolor mr-2">Privacy Policy</a>
                <a href="{{ URL::to('Terms') }}" class="textcolor mr-2">Terms and Conditions</a>
                <a href="{{ URL::to('Contact') }}" class="textcolor">Contact Us</a>
            </div>

        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        function submitForm() {
            // Show loader
            $('#loader').removeClass('d-none');

            // Get form data
            var formData = {
                email: $('#email').val(),
                reason: $('#reason').val(),
            };

            // Send AJAX request
            $.ajax({
                type: 'POST',
                url: '/deleteAccount',
                data: formData,
                dataType: 'json',
                success: function(data) {
                    console.log('Success:', data);
                    $('#email').val('');
                    $('#reason').val('');
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);

                    // Display error message
                    var errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error :
                        'An error occurred.';
                    $('#errorAlert').text(errorMessage).removeClass('hidden');

                    setTimeout(function() {
                        $('#errorAlert').addClass('hidden').text('');
                    }, 5000);
                },
                complete: function() {
                    $('#loader').addClass('d-none');
                }
            });
        }
    </script>



</body>

</html>
