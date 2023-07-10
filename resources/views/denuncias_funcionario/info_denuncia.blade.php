@extends('layouts.adminPage')

@section('header')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.css" rel="stylesheet" />
@endsection


@section('content')
    <div class="flex flex-col items-center justify-center p-2 m-2 bg-green-200 h-5/6 p-4 border-2 border-gray-500 border-dashed rounded-lg mt-20">
        <h3 class="mb-4 text-2xl font-bold text-gray-900 dark:text-white">Informacion denuncia</h3>
        <div class="flex">
            <div class="flex flex-col justify-center">
                <p class="text-lg"><span class="font-semibold">Titulo:</span> {{$denuncia->titulo}}</p>
                <p class="text-lg"><span class="font-semibold">Descripcion:</span> {{$denuncia->descripcion}}</p>
                <p class="text-lg"><span class="font-semibold">Fecha registro:</span> {{$denuncia->fecha_creacion}}</p>
                <p class="text-lg"><span class="font-semibold">Area:</span> {{$area->nombre}}</p>
                <p class="text-lg"><span class="font-semibold">Tipo:</span> {{$tipo->nombre}}</p>
                <p class="text-lg"><span class="font-semibold">Estado:</span>
                    <select id="estados" onchange="actualizar_estado()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-fit p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @foreach ($estados as $estado1)
                            <option value="{{$estado1->id}}">{{$estado1->nombre}}</option>
                        @endforeach
                    </select>
                    <div class="flex items-center">
                        <input id="micheck" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checked-checkbox" class="ml-2 text-sm font-medium text-gray-600 dark:text-gray-300">modificar estado</label>
                    </div>
                </p>


            </div>
            <div>
                <img class="rounded-full" src="{{$foto->url}}" alt="foto_denuncia" width="500" height="500">
            </div>
        </div>

    </div>

@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>
    <script>
        console.log({!! $estado !!});
          let select = document.getElementById("estados");
          select.value = {!! $estado->id !!};  
          select.setAttribute("disabled", "disabled");

          var miCheckbox = document.getElementById('micheck');

            miCheckbox.addEventListener('click', function() {
                if(miCheckbox.checked) {
                    select.removeAttribute("disabled");
                }else{
                    select.setAttribute("disabled", "disabled");
                }

            });

        function actualizar_estado() {
            select.setAttribute("disabled", "disabled");
            miCheckbox.checked=false;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const url = 'http://127.0.0.1:8000/api/cambiarEstadoDenuncia';
            const data = {
            id_denuncia:{!! $denuncia->id !!},
            id_estado: estados.value
            };

            fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
            })
            .then(datos => {

                console.log("estado cambiado");
            })        
            .catch(error => {
                // Manejar errores
                console.error('Error:', error);
            });
            }
    </script>
@endsection
