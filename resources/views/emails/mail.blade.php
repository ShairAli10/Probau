<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
</head>

<style>
    .block {
        display: flex;
    }

    @media screen and (max-width: 768px) {
        .block {
            display: block;
        }
    }
</style>

<body>
    <div style="padding: 52px; ">
        <div style="padding-bottom: 40px; margin-bottom: 20px;">
            <img src="https://admin.probau.app/public/frontend/media/loginLogo.png" alt="">
        </div>
        <div style="margin: 5px;">

            <h2 class="title my-4 font-weight-normal text"
                style="font-style: normal; font-weight: 400; font-size: 15.5874px; line-height: 37px; color: #333333; margin-top: 20px;">
               Dear {{ $data['userName'] }},
               
            </h2>
            <h2 class="title my-4 font-weight-normal text"
                style="font-style: normal; font-weight: 400; font-size: 15.5874px; line-height: 37px; color: #333333;">
                {{ $data['message'] }}
            </h2>

            <div style=" margin-top: 170px; justify-content: center;">
                <p>If you’d rather not receive this kind of email, you can unsubscribe or manage your email preferences.</p>
                
                <p style="margin-bottom: 30px;"> Probau, 221B Downtown Street, San Francisco CA 79231</p>
            </div>

            <div style=" margin-top: 70px; justify-content:space-between; align-content:between; display:flex;">
                <div style="padding-bottom: 40px; margin-bottom: 20px;">
                    <img src="https://admin.probau.app/public/frontend/media/mailfooterlogo.png" alt="">
                </div>
                
                <div style="margin-bottom: 30px;">
                    <ul style="display: flex;  justify-content: center; margin-bottom:10px; padding:0px">
                        <p
                            style="margin:10px; max-width: 20px; display: flex; text-align: center; justify-content: center; margin-bottom:20px; ">
                            <a href="https://twitter.com/"><img
                                    src="https://admin.probau.app/frontend/media/twitter.png" alt=""
                                    style="max-width: 20px;"></a>
                        </p>
                        <p
                            style="margin:10px; max-width: 20px; display: flex; text-align: center; justify-content: center; margin-bottom:20px; ">
                            <a href="https://facebook.com/"><img
                                    src="https://admin.probau.app/frontend/media/facebook.png" alt=""
                                    style="max-width: 20px;"></a>
                        </p>
                        <p
                            style="margin:10px; max-width: 20px; display: flex; text-align: center; justify-content: center; margin-bottom:20px; ">
                            <a href="https://www.linkedin.com/"><img
                                    src="https://admin.probau.app/frontend/media/linkdin.png" alt=""
                                    style="max-width: 20px;"></a>
                        </p>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>


</html>
