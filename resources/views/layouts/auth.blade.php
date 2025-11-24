<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking System</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f5f6fa;
            font-family: Arial, sans-serif;
        }

        .auth-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
            font-weight: 600;
        }

        label {
            font-size: 14px;
            font-weight: 600;
            color: #444;
            margin-bottom: 5px;
            display: block;
        }

        .auth-card {
            width: 420px;
            background: #ffffff;
            padding: 40px 45px;
            border-radius: 16px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.08);
        }

        input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        input:focus {
            border-color: #4a90e2;
            outline: none;
            box-shadow: 0 0 4px rgba(74, 144, 226, 0.5);
        }

        button {
            width: 100%;
            padding: 12px;
            background: #4a90e2;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s ease;
        }

        button:hover {
            background: #357ABD;
        }

        .auth-link {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        .auth-link a {
            color: #4a90e2;
            text-decoration: none;
            font-weight: 600;
        }

        .error-msg {
            color: red;
            font-size: 13px;
            margin-top: -10px;
            margin-bottom: 10px;
        }

        .alert-success {
            background: #d7f7d7;
            padding: 10px;
            border-left: 4px solid #2ecc71;
            color: #2d7a2d;
            margin-bottom: 15px;
            border-radius: 6px;
        }

        .alert-error {
            background: #fde3e3;
            padding: 10px;
            border-left: 4px solid #e74c3c;
            color: #b33939;
            margin-bottom: 15px;
            border-radius: 6px;
        }
    </style>
</head>

<body>

    <div class="auth-container">
        <div class="auth-card">
            @yield('content')
        </div>
    </div>

</body>

</html>