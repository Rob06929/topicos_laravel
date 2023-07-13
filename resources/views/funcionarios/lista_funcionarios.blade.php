@extends('layouts.adminPage2')

@section('header')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.css" rel="stylesheet" />
@endsection


@section('content')
<div class="flex items-center justify-center flex-col h-5/6 p-4 border-2 border-gray-200 border-dashed rounded-lg mt-20">

    <!-- Modal toggle -->
    <div class="w-full">
        <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class=" m-3 block text-white bg-green-500 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
            Crear Funcionario
        </button>
    </div>

    
    <h1 class="text-center text-2xl font-bold p-3">Lista Funcionario</h1>
    <div class="relative overflow-x-auto w-full">
        <table class="border-collapse border border-slate-100 w-4/5 text-sm text-left m-auto">
            <thead class="bg-green-500 text text-white text-lg w-full">
                <tr>
                    <th scope="col" class="border-2 border-slate-100 p-3">
                        #
                    </th>
                    <th scope="col" class="border-2 border-slate-100 p-3">
                        Nombre
                    </th>
                    <th scope="col" class="border-2 border-slate-100 p-3">
                        Usuario
                    </th>
                    <th scope="col" class="border-2 border-slate-100 p-3">
                        CI
                    </th>
                    <th scope="col" class="border-2 border-slate-100 p-3">
                        E-mail
                    </th>
                    <th scope="col" class="border-2 border-slate-100 p-3">
                        Celular
                    </th>
                    <th scope="col" class="border-2 border-slate-100 p-3">
                        Direccion
                    </th>
                    <th scope="col" class="border-2 border-slate-100 p-3">
                        Area
                    </th>
                    <th scope="col" class="border-2 border-slate-100 p-3">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $a=1;
                @endphp
        
                @foreach ($funcionarios as $funcionario)
                <tr>
                    <td scope="row" class="border-2 border-slate-100 p-3">
                        {{$a}}
                     </td>
                    <td scope="row" class="border-2 border-slate-100 p-3">
                       {{$funcionario->nombre}}
                    </td>
                    <td class="border-2 border-slate-100 p-3">
                        {{$funcionario->name}}
                    </td>
                    <td class="border-2 border-slate-100 p-3">
                        {{$funcionario->ci}}
                    </td>
                    <td class="border-2 border-slate-100 p-3">
                        {{$funcionario->email}}
                    </td>
                    <td class="border-2 border-slate-100 p-3">
                        {{$funcionario->telefono}}
                    </td>
                    <td class="border-2 border-slate-100 p-3">
                        {{$funcionario->direccion}}
                    </td>
                    <td class="border-2 border-slate-100 p-3">
                        {{$funcionario->nombre_area}}
                    </td >
                
                    <td class="border-2 border-slate-100 p-3">
                        <a href="{{ route('perfil_funcionario', ['id'=>$funcionario->id]) }}" type="button" class="px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Ver</a>
                    </td>
                </tr>
                @php
                    $a=$a+1;
                @endphp
                @endforeach
            </tbody>
          </table>
    </div>
    <div class="row">
        <div class="col-md-12">
            {{ $funcionarios->links('pagination::tailwind') }}
        </div>
    </div>
    
    
        
    </div>
    
      
    <!-- Main modal -->
    <div id="authentication-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Formulario de registro</h3>
                    <form class="space-y-6" action="{{ route('registro_funcionario') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                        </div>
                        <div>
                            <label for="usuario" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Usuario</label>
                            <input type="text" name="usuario" id="usuario" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                        </div>
                        <div>
                            <label for="celular" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Celular</label>
                            <input type="number" name="celular" id="celular" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                        </div>
                        <div>
                            <label for="ci" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">CI</label>
                            <input type="number" name="ci" id="ci" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contraseña</label>
                            <input type="password" value="" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                        </div>
                        <div>
                            <label for="direccion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dirección</label>
                            <input type="text" name="direccion" id="direccion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                        </div>
                        <div>
                            <label for="id_area" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lista de areas</label>
                            <select id="id_area" name="id_area" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                              <option selected>Seleccionar Area</option>
                              @foreach ($areas as $area)
                                <option value="{{$area->id}}">{{$area->nombre}}</option>
                              @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_foto">Seleccione foto</label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" name="file_foto" id="file_foto" type="file">
                        </div>

    
                        <button type="submit" class="w-full text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Guardar</button>
    
                </div>
            </div>
        </div>
    </div> 

@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>
@endsection
