<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Page Not Found</title>

    {{-- <meta http-equiv="refresh" content="3;url=/" /> --}}

    <script>
        setTimeout(() => {
            window.location.href = "/";
        }, 9000);
    </script>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }

        .container {
            max-width: 500px;
        }

        h1 {
            font-size: 80px;
            margin: 0;
            color: #FFBE42;
        }

        h2 {
            margin: 10px 0;
            font-weight: 600;
        }

        p {
            margin: 10px 0 20px;
            color: #666;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            background: #0078BF;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
        }

        a:hover {
            background: #005f94;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>404</h1>
        <h2>Oops! Page not found</h2>
        <p>You’ll be redirected to the homepage in 10 seconds.</p>

        <a href="/">Go Home Now</a>
    </div>
</body>
</html>