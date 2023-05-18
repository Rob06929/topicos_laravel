<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="flex justify-center items-center h-screen">
        <button class="py-3 px-6 bg-blue-500 text-white font-semibold rounded-lg shadow-md">
            <a href="{{ config('app.url') }}/api/actions/confirmation_register/{{$uid}}/{{$id_usuario}}">Confirmar el correo</a>
        </button>
    </div>
    
</body>
</html>