<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #74ebd5 0%, #ACB6E5 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .card {
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        h2 {
            margin-bottom: 1rem;
            color: #333;
        }
        p {
            color: #555;
            margin: 0.5rem 0;
        }
        h1 {
            font-size: 2.5rem;
            color: #4CAF50;
            margin: 1rem 0;
            letter-spacing: 4px;
        }
        .expiry {
            font-size: 0.9rem;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Your OTP Code</h2>
        <p>Your verification code is:</p>
        <h1>{{ $otp }}</h1>
        <p class="expiry">This OTP will expire in 10 minutes.</p>
    </div>
</body>
</html>
