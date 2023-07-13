@extends('layouts.adminPage2')

@section('header')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.css" rel="stylesheet" />
@endsection


@section('content')
<div class="flex items-center justify-center flex-col h-5/6 p-4 border-2 border-gray-200 border-dashed rounded-lg mt-20">

<!-- Modal toggle -->
<div class="w-full">
    <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class=" m-3 block text-white bg-green-500 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
        Crear Area
    </button>
</div>


<h1 class="text-center text-2xl font-bold p-3">Lista de Areas</h1>
<table class="border-collapse border border-slate-100 w-4/5 text-sm text-left">
    <thead class="bg-green-500 text text-white text-lg">
        <tr>
            <th scope="col" class="border-2 border-slate-100 p-3">
                #
            </th>
            <th scope="col" class="border-2 border-slate-100 p-3">
                Nombre de area
            </th>
            <th scope="col" class="border-2 border-slate-100 p-3">
                Descripcion de area
            </th>

        </tr>
    </thead>
    <tbody>
        @php
            $a=0;
        @endphp

        @foreach ($areas as $area)
        <tr>
            <td scope="row" class="border-2 border-slate-100 p-3">
                {{$a}}
             </td>
            <td scope="row" class="border-2 border-slate-100 p-3">
               {{$area->nombre}}
            </td>
            <td class="border-2 border-slate-100 p-3">
                {{$area->descripcion}}
            </td>
        </tr>
        @php
            $a=$a+1;
        @endphp
        @endforeach
    </tbody>
  </table>

  <div class="row m-3">
    <div class="col-md-12">
        {{ $areas->links('pagination::tailwind') }}
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
                <form class="space-y-6" action="{{ route('registro_area') }}" method="POST">
                    @csrf
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre de area</label>
                        <input type="text" name="nombre" id="nombre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripcion</label>
                        <input type="text" name="descripcion" id="descripcion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
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
