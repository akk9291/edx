<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello Test Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .container {
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        h1 {
            color: #667eea;
            font-size: 48px;
            margin: 0;
        }
        p {
            color: #666;
            font-size: 18px;
            margin-top: 20px;
        }
        .success {
            color: #10b981;
            font-weight: bold;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎉 Hello!</h1>
        <p>Navigation is working perfectly!</p>
        <p class="success">✓ You successfully navigated to this test page</p>
        <p style="margin-top: 30px;">
            <a href="{{ route('cart.index') }}" style="color: #667eea; text-decoration: underline;">← Back to Cart</a>
        </p>
    </div>
</body>
</html>
