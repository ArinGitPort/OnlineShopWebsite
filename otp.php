<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="stylingfile/register.css">
    <link rel="icon" href="iconlogo/bunniwinkleIcon.ico">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter OTP</title>
    <style>
        body {
            background: rgb(238,174,202);
            background: radial-gradient(circle, rgba(238,174,202,1) 0%, rgba(148,187,233,1) 100%);
            font-family: "Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif;
        }

        .otpContainer {
            display: inline-block;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            align-items: center;
            border: solid 2px;
            border-radius: 8px;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.5);
            width: 300px;
            height: 200px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.7);
            text-align: center;
        }

        .otpInput {
            border: none;
            outline: none;
            border-radius: 8px;
            padding: 1em;
            background-color: #ccc;
            box-shadow: inset 2px 5px 10px rgba(0,0,0,0.3);
            transition: 300ms ease-in-out;
            width: 80%;
            text-align: center;
            font-size: 16px;
        }

        .otpInput:hover {
            background-color: white;
            transform: scale(1.05);
            box-shadow: 13px 13px 100px #969696, -13px -13px 100px #ffffff;
        }

        .submitButton {
            border-radius: 10px;
            background-color: pink;
            border: none;
            padding: 6px;
            font-size: 20px;
            margin-top: 10px;
            transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s;
            cursor: pointer;
            width: 50%;
        }

        .submitButton:hover {
            background-color: hotpink;
            box-shadow: 0 0 6px rgba(184, 112, 112, 1);
            transform: scale(1.1);
        }
    </style>
</head>

<body>
    <div class="otpContainer">
        <h2>Enter Your OTP</h2>
        <form method="POST" action="">
            <input type="text" name="otp" class="otpInput" placeholder="Enter OTP" required><br>
            <input type="submit" value="Submit" class="submitButton">
        </form>
    </div>
</body>

</html>
