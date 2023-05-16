<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página de Registro</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <style>

        .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        }

        ul {
        list-style: none;
        padding: 0;
        margin: 0;
        }

        a {
        color: inherit;
        text-decoration: none;
        }

        a:hover {
        text-decoration: underline;
        }
  </style>
</head>
<body class="bg-green-100">
  <header class="bg-green-500 text-white py-4">
    <div class="container mx-auto flex justify-between items-center">
      <h1 class="text-xl font-bold">Mi Sitio Web</h1>
      <nav>
        <ul class="flex space-x-4">
          <li><a href="#" class="text-white">Inicio</a></li>
          <li><a href="#" class="text-white">Acerca de</a></li>
          <li><a href="#" class="text-white">Servicios</a></li>
          <li><a href="#" class="text-white">Contacto</a></li>
          <li><a href="#" class="text-white bg-blue-500 px-4 py-2 rounded">Login</a></li>
          <li><a href="#" class="text-white bg-green-500 px-4 py-2 rounded">Registro</a></li>
        </ul>
      </nav>
    </div>
  </header>
  
  <main class="container mx-auto py-8 bg-white rounded shadow-lg">
    <h2 class="text-2xl font-bold mb-4">Registro de Usuario</h2>
    <form>
      <div class="mb-4">
        <label for="nombre" class="block text-gray-700">Nombre</label>
        <input type="text" id="nombre" name="nombre" class="border border-gray-300 rounded px-4 py-2 w-full">
      </div>
      <div class="mb-4">
        <label for="email" class="block text-gray-700">Email</label>
        <input type="email" id="email" name="email" class="border border-gray-300 rounded px-4 py-2 w-full">
      </div>
      <div class="mb-4">
        <label for="password" class="block text-gray-700">Contraseña</label>
        <input type="password" id="password" name="password" class="border border-gray-300 rounded px-4 py-2 w-full">
      </div>
      <div class="text-center">
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Registrarse</button>
      </div>
    </form>
  </main>
</body>
</html>