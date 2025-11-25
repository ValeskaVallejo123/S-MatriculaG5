<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Error</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        .box {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            font-size: 60px;
            margin: 0;
            color: #e74c3c;
        }
        p {
            font-size: 20px;
            margin: 15px 0;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            background: #3498db;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>

<div class="box">
    <h1>@yield('code')</h1>
    <p>@yield('message')</p>
    <a href="{{ url('/') }}">Regresar al inicio</a>
</div>

</body>
</html>
