@extends('layouts.adminPage2')

@section('header')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

@endsection


@section('content')
    <div class="flex flex-col items-center justify-center p-2 m-2 h-full p-4 mt-20">
        <h3 class="mb-4 text-2xl font-bold text-gray-900 dark:text-white">Informacion denuncia</h3>
        <div class="flex flex-col">
            <div class="flex flex-col justify-center">
                <p class="text-lg text-center"><span class="font-semibold">Titulo:</span> {{$denuncia->titulo}}</p>
                <p class="text-lg text-center"><span class="font-semibold">Descripcion:</span> {{$denuncia->descripcion}}</p>
                <p class="text-lg text-center"><span class="font-semibold">Fecha registro:</span> {{$denuncia->fecha_creacion}}</p>
                <p class="text-lg text-center"><span class="font-semibold">Area:</span> {{$area->nombre}}</p>
                <p class="text-lg text-center"><span class="font-semibold">Tipo:</span> {{$tipo->nombre}}</p>
                <p class="text-lg text-center"><span class="font-semibold">Estado:</span>
                    <select id="estados" onchange="actualizar_estado()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-fit p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @foreach ($estados as $estado1)
                            <option value="{{$estado1->id}}">{{$estado1->nombre}}</option>
                        @endforeach
                    </select>
                </p>
                <div class="flex items-center justify-center text-center">
                        <input id="micheck" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checked-checkbox" class="ml-2 text-sm font-medium text-gray-600 dark:text-gray-300">modificar estado</label>
                </div>
                


            </div>
            <div class="flex">
                <div class="m-4 border-2 border-black " id ="map" style="width: 500px; height: 500px;"> </div> 
                <img class="m-4 border-2 border-black" src="{{$foto->url}}" alt="foto_denuncia" width="500" height="500">
            </div>
        </div>

        <textarea id="message" rows="4" class="block p-2.5 w-full m-3 text-sm text-gray-900 bg-gray-50 invisible rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 h-fit" placeholder="escriba mensaje para el denunciante"></textarea>
        <input hidden id="id_user" type="text" value="{{$usuario_denuncia->id}}">
    </div>

    <button hidden id="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="initFirebaseMessagingRegistration()" class="btn btn-danger btn-xs btn-flat">Allow for Notification</button>


    <form hidden action="{{ route('send.web-notification') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Message Title</label>
            <input type="text" class="form-control" name="title">
        </div>
        <div class="form-group">
            <label>Message Body</label>
            <textarea class="form-control" name="body"></textarea>
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Send Notification</button>
    </form>


@endsection
@section('script')
    <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2iKcRjgOKH2Kzv1hqSCM18wan1a1cr68&callback=initMap&v=weekly"
    defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

    <script>
        console.log({!! $estado !!});
          let select = document.getElementById("estados");
          var d = document.getElementById("message");

          var id_user = document.getElementById("id_user");

          select.value = {!! $estado->id !!};  
          select.setAttribute("disabled", "disabled");

          var miCheckbox = document.getElementById('micheck');

            miCheckbox.addEventListener('click', function() {
                if(miCheckbox.checked) {
                    select.removeAttribute("disabled");
                    d.classList.add("visible");
                    d.classList.remove("invisible");


                }else{
                    select.setAttribute("disabled", "disabled");
                    d.classList.add("invisible");
                    d.classList.remove("visible");
                }

            });

        
        
        function actualizar_estado() {
            d.classList.add("invisible");
            select.setAttribute("disabled", "disabled");
            miCheckbox.checked=false;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const url = 'http://127.0.0.1:8000/api/cambiarEstadoDenuncia';
            const data = {
            id_denuncia:{!! $denuncia->id !!},
            id_estado: estados.value,
            id_user:id_user.value,
            message:d.value
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

<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
<script>
    var firebaseConfig = {
        apiKey: "AIzaSyAyuZeFolE9e6gNoml_z6Abb1Xp8WM76Cw",
        authDomain: "complaints-notifications.firebaseapp.com",
        projectId: "complaints-notifications",
        storageBucket: "complaints-notifications.appspot.com",
        messagingSenderId: "722124102953",
        appId: "1:722124102953:web:35b6acd6b24891d94feb38"
    };
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();

    function initFirebaseMessagingRegistration() {
            messaging
            .requestPermission()
            .then(function () {
                return messaging.getToken()
            })
            .then(function(token) {
                console.log(token);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ route("store.token") }}',
                    type: 'POST',
                    data: {
                        token: token
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        alert('Token saved successfully.');
                    },
                    error: function (err) {
                        console.log('User Chat Token Error'+ err);
                    },
                });

            }).catch(function (err) {
                console.log('User Chat Token Error'+ err);
            });
     }

    messaging.onMessage(function(payload) {
        const noteTitle = payload.notification.title;
        const noteOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(noteTitle, noteOptions);
    });

    var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: {!! $denuncia->latitud !!}, lng: {!! $denuncia->longitud !!}},
          zoom: 13
        });
        var marker = new google.maps.Marker({
          position: {lat: {!! $denuncia->latitud !!}, lng: {!! $denuncia->longitud !!}},
          map: map,
	  title: 'Acuario de Gijón'
        });
      }

      
</script>
@endsection
