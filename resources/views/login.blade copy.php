<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <style>
    .lds-ring {
      display: inline-block;
      position: relative;
      width: 80px;
      height: 80px;
    }
    .lds-ring div {
      box-sizing: border-box;
      display: block;
      position: absolute;
      width: 64px;
      height: 64px;
      margin: 8px;
      border: 8px solid #004904;
      border-radius: 50%;
      animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
      border-color: #004904 transparent transparent transparent;
    }
    .lds-ring div:nth-child(1) {
      animation-delay: -0.45s;
    }
    .lds-ring div:nth-child(2) {
      animation-delay: -0.3s;
    }
    .lds-ring div:nth-child(3) {
      animation-delay: -0.15s;
    }
    @keyframes lds-ring {
      0% {
        transform: rotate(0deg);
      }
      100% {
        transform: rotate(360deg);
      }
    }

  </style>
</head>
<body class="bg-green-100">
  <div class="min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full px-6 py-8 bg-white rounded-lg shadow-md">
      <h2 class="text-2xl font-bold mb-8 text-center">Iniciar sesión</h2>
      <form method="" id="formulario" action="">
        <div class="mb-4">
          <label for="email" class="block text-gray-700">Usuario</label>
          <input type="email" id="email" name="email" class="border border-gray-300 rounded px-4 py-2 w-full">
        </div>
        <div class="mb-4">
          <label for="password" class="block text-gray-700">Contraseña</label>
          <input type="password" id="password" name="password" class="border border-gray-300 rounded px-4 py-2 w-full">
        </div>
        <div class="mb-4">
          <label for="image" class="block text-gray-700">Imagen</label>
          <input type="file" id="image" name="image" class="border border-gray-300 rounded px-4 py-2 w-full">
          <div id="image-preview" class="mt-2"></div>
          <div class="flex items-center justify-center hidden">
            <div class="max-w-md w-full bg-white rounded-lg shadow-md flex items-center justify-center">
              <div id="verifying-icon" class="w-16 h-16 rounded-full  flex items-center justify-center">
                <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
              </div>
              <div id="verifying-text" class="ml-4 text-xl">Verificando...</div>
            </div>
          </div>
        </div>
        <div class="text-center">
          <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded" id="boton">Verificar y ingresar</button>
        </div>
      </form>
    </div>
  </div>
  <script>

    const boton = document.getElementById('envio');

    boton.addEventListener('click', function() {
        const formulario = document.getElementById('formulario');

        formulario.addEventListener('submit', function(event) {
        event.preventDefault();
        // Tu código aquí
        });
        procesarDatos();
    });
    var nombre_usuario="evo";

    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');

    imageInput.addEventListener('change', function(event) {
      const file = event.target.files[0];
      const reader = new FileReader();

      reader.onload = function(event) {
        const imageUrl = event.target.result;
        const imageElement = document.createElement('img');
        imageElement.src = imageUrl;
        imageElement.classList.add('w-32', 'h-32', 'mx-auto', 'mt-2', 'rounded-full', 'border', 'border-gray-300');
        imageElement.id="imageElement";
        imagePreview.innerHTML = '';
        imagePreview.appendChild(imageElement);
       
      };

      reader.readAsDataURL(file);
    });

    // Simulando un proceso de verificación que tarda 3 segundos
    setTimeout(function() {
      // Ocultar el icono de verificación y mostrar un mensaje de éxito
      document.getElementById('verifying-icon').style.display = 'none';
      document.getElementById('verifying-text').textContent = 'Verificación completada';
    }, 3000);
  </script>
</body>
</html>