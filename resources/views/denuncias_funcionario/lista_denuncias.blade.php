@extends('layouts.adminPage2')

@section('header')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.css" rel="stylesheet" />
@endsection


@section('content')

    <div class="flex flex-wrap items-center justify-center mt-20 ">
        <form action="{{ route('getFiltro') }}" method="post">
            @csrf
            <div class="flex">
                <div class="ml-8 flex items-center">
                    <div class="flex">
                        <label for="opciones_estado" class="block text-gray-700">Estado</label>
                        <select id="opciones_estado" name="opciones_estado" class="border border-gray-300 rounded ml-1">
                            <option selected value="0">Todos</option>  
                            @foreach ($estados as $estado)
                            <option value="{{$estado->id}}">{{$estado->nombre}}</option>  
                            @endforeach
                        
                        </select>
                    </div>
                </div>
                <div class="ml-8 flex items-center">
                    <div class="flex">
                        <label for="opciones_tipo" class="block text-gray-700">Tipo</label>
                        <select id="opciones_tipo" name="opciones_tipo" class="border border-gray-300 rounded ml-1">
                            <option selected value="0">Todos</option>  
                            @foreach ($tipos as $tipo)
                            <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>  
                            @endforeach
                        
                        </select>
                    </div>
                </div>
                <div class="ml-8 flex items-center">
                    <div class="flex">
                        <label for="opciones_periodo" class="block text-gray-700">Periodo</label>
                        <select id="opciones_periodo" name="opciones_periodo" class="border border-gray-300 rounded ml-1">
                            <option selected value="0">Todos</option>  
                            <option value="1">1 día</option>
                            <option value="7">7 días</option>
                            <option value="30">30 días</option>
                        </select>
                    </div>
                </div>
                <div class="ml-8 flex items-center">
                    <button type="submit" class="px-3 py-2 text-xs font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">filtrar</button>
                </div>
        </form>   
        </div>    
        <div class="flex flex-wrap items-center justify-center m-2 ">
            @foreach ($denuncias as $denuncia)
            <a href="{{ route('info_denuncia', ['id'=>$denuncia->id]) }}" class="block shadow-2xl shadow-green-100 m-4 h-fit w-80 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                <img src="{{ $denuncia->denuncia_image }}" alt="Imagen de la denuncia" class="w-full rounded-t-lg">
                <div class="m-1">
                    <p>Titulo: {{ $denuncia->titulo }}</p>
                    <p>Descripcion: {{ $denuncia->descripcion }}</p>
                    <p>Estado: {{ $denuncia->nombre_estado }}</p>
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
    </div>

@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>
@endsection
