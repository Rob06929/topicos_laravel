@extends('layouts.adminPage')

@section('header')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.css" rel="stylesheet" />
@endsection


@section('content')
    <div class="flex h-5/6 p-4 border-2 border-gray-200 border-dashed rounded-lg mt-20">

        @foreach ($denuncias as $denuncia)
            <div class="p-3 m-2 border-2 h-fit w-fit">
                <img src="{{ $denuncia->denuncia_image }}" alt="Imagen de la denuncia" class="w-full">
                <div class="mt-2">
                    <p>Titulo: {{ $denuncia->titulo }}</p>
                    <p>Descripcion: {{ $denuncia->descripcion }}</p>
                    <p>Fecha creacion: {{ $denuncia->fecha_creacion }}</p>
                </div>
            </div>
        @endforeach
    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>
@endsection
