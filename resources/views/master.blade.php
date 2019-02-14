<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <meta name='csrf-token' content='{{ csrf_token() }}'>
    <title>Seminovos</title>
    <style>
        .container{
            padding-top: 10px;
        }
	.descricao{
            padding: 20px;
        } 
    </style>
</head>
<body>
    <div class="container">
        <main role="main">
            @yield('body')
        </main>
    </div>    
</body>
</html>