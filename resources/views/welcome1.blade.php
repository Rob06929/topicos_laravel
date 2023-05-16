<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página de Bienvenida</title>
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
<body>
  <header class="bg-gray-800 text-white py-4">
    <div class="container mx-auto flex justify-between items-center">
      <h1 class="text-xl font-bold">Mi Sitio Web</h1>
      <nav>
        <ul class="flex space-x-4">
          <li><a href="#" class="text-white">Inicio</a></li>
          <li><a href="#" class="text-white">Acerca de</a></li>
          <li><a href="#" class="text-white">Servicios</a></li>
          <li><a href="#" class="text-white">Contacto</a></li>
          <li><a href="{{ route('login') }}" class="text-white bg-blue-500 px-4 py-2 rounded">Login</a></li>
          <li><a href="{{ route('register') }}" class="text-white bg-green-500 px-4 py-2 rounded">Registro</a></li>
        </ul>
      </nav>
    </div>
  </header>
  
  <main class="container mx-auto py-8">
    <h2 class="text-2xl font-bold mb-4">Bienvenido a Mi Sitio Web</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lobortis velit vel turpis eleifend, ac condimentum mi ultrices. Nulla sed massa libero.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lobortis velit vel turpis eleifend, ac condimentum mi ultrices. Nulla sed massa libero.</p>
  </main>
</body>
</html>