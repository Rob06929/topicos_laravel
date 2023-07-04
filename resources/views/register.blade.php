
@extends('layouts.main')

@section('header')

@endsection

@section('content')

<div class="bg-white shadow rounded-lg w-auto" style="width: 500px">
  <div class="px-5 py-7">
      <h2 class="text-center font-bold text-gray-700 text-2xl">Iniciar sesión</h2>
      <form class="mt-7" action="#" method="POST" id="formulario">
          <label class="font-semibold text-sm text-gray-600 pb-1 block">Nombre de usuario</label>
          <input type="text" name="username" id="username"
              class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full focus:outline-none focus:shadow-outline-blue"
              placeholder="Escribe tu nombre de usuario" autofocus />

          <label class="font-semibold text-sm text-gray-600 pb-1 block">Contraseña</label>

          <input type="text" id="image" name="image" class="border rounded w-full py-2 px-3"
          placeholder="Escribe tu contraseña" >
          {{-- <h2 class="font-bold text-gray-700 mb-2">Vista previa:</h2>
          <img src="/images/joven2.jpg" id="originalImg" class="h-48 w-auto object-contain bg-gray-300" width="1400" height="800">
          <canvas id="reflay" class="overlay" hidden ></canvas> --}}

          <div class="flex justify-center">
          <button type="submit" id="envio"
              class="transition duration-500 ease-in-out bg-blue-500 hover:bg-blue-600 transform hover:-translate-y-1 hover:scale-110 text-white font-bold py-2 px-4 rounded-full w-full max-w-xs mx-auto mt-5">Iniciar
              sesión</button>
          </div>
      </form>
  </div>
</div>
  <main class="container mx-auto py-8 bg-white rounded shadow-lg w-1/2 ">
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
@endsection