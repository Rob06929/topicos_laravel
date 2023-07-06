@extends('layouts.adminPage')

@section('header')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.css" rel="stylesheet" />
@endsection


@section('content')
    <div class="flex flex-wrap items-center justify-center p-2 m-2 bg-green-200 h-fit p-4 border-2 border-gray-500 border-dashed rounded-lg mt-20">

        @foreach ($denuncias as $denuncia)
            <a href="#" class="block p-6 m-4 h-fit w-64 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                <img src="{{ $denuncia->denuncia_image }}" alt="Imagen de la denuncia" class="w-full">
                <div class="mt-2">
                    <p>Titulo: {{ $denuncia->titulo }}</p>
                    <p>Descripcion: {{ $denuncia->descripcion }}</p>
                    <p>Fecha creacion: {{ $denuncia->fecha_creacion }}</p>
                </div>
            </a>

        @endforeach
    </div>
    <div class="row">
        <div class="col-md-12">
            {{ $denuncias->links('pagination::tailwind') }}
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>
@endsection
