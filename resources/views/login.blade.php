
@extends('layouts.main')

@section('header')

@endsection

@section('content')
      <div class="bg-white shadow rounded-lg w-auto" style="width: 500px">
                    <div class="px-5 py-7">
                        <h2 class="text-center font-bold text-gray-700 text-2xl">Iniciar sesión</h2>
                        <form class="mt-7" action="{{ route('login_user') }}" method="POST">
                            @csrf
                            <label class="font-semibold text-sm text-gray-600 pb-1 block">Correo electronico</label>
                            <input type="email" name="email"
                                class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full focus:outline-none focus:shadow-outline-blue"
                                placeholder="Escribe correo electronico" autofocus />

                            <label class="font-semibold text-sm text-gray-600 pb-1 block">Contraseña</label>

                            <input type="password" name="password" class="border rounded w-full py-2 px-3"
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
@endsection

@section('script')

    <script src="/js/jquery-2.1.1.min.js"></script>

    <script src="/js/face-api.js"></script>

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
        var nombre_usuario = "evo";
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');



        function procesarDatos() {
            let username = document.getElementById("username");
            console.log(username.value);

            const xhr = new XMLHttpRequest();
            const url = 'http://127.0.0.1:8000/verificar';
            const data = JSON.stringify({
                username: username.value
            });

            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);


            xhr.onload = function() {
                if (this.status === 200) {
                    const response = JSON.parse(this.responseText);
                    console.log(response);
                    nombre_usuario = response.url;
                    console.log(nombre_usuario);
                    face()
                }
            };

            xhr.onerror = function() {
                console.log('Error al realizar la petición.');
            };

            xhr.send(data);
        }

        function previewImage() {
            const preview = document.getElementById('preview');
            const file = document.getElementById('image').files[0];
            const reader = new FileReader();

            reader.addEventListener('load', function() {
                preview.src = reader.result;
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        function mensajeExito() {
            const loginAlert = document.querySelector('.login-alert1');
            loginAlert.classList.remove('hidden');
            //loginAlert.classList.add('opacity-0');
        }

        function mensajeError() {
            const loginAlert = document.querySelector('.login-alert2');
            loginAlert.classList.remove('hidden');

            //loginAlert.classList.add('opacity-0');

        }

        async function face() {
            const MODEL_URL = './models'

            await faceapi.loadSsdMobilenetv1Model(MODEL_URL)
            await faceapi.loadFaceLandmarkModel(MODEL_URL)
            await faceapi.loadFaceRecognitionModel(MODEL_URL)
            await faceapi.loadFaceExpressionModel(MODEL_URL)

            const img = document.getElementById('originalImg')
            let faceDescriptions = await faceapi.detectAllFaces(img).withFaceLandmarks().withFaceDescriptors()
                .withFaceExpressions()
            const canvas = $('#reflay').get(0)
            faceapi.matchDimensions(canvas, img)

            faceDescriptions = faceapi.resizeResults(faceDescriptions, img)
            faceapi.draw.drawDetections(canvas, faceDescriptions)
            faceapi.draw.drawFaceLandmarks(canvas, faceDescriptions)
            faceapi.draw.drawFaceExpressions(canvas, faceDescriptions)


            const labels = [];
            labels.push(nombre_usuario);

            const labeledFaceDescriptors = await Promise.all(
                labels.map(async label => {

                    const imgUrl = `images/${label}.jpg`
                    const img1 = await faceapi.fetchImage(imgUrl)

                    const faceDescription = await faceapi.detectSingleFace(img1).withFaceLandmarks()
                        .withFaceDescriptor()
                    console.log("aaaaaaaaaa");

                    if (!faceDescription) {
                        throw new Error(`no faces detected for ${label}`)
                    }

                    const faceDescriptors = [faceDescription.descriptor]
                    return new faceapi.LabeledFaceDescriptors(label, faceDescriptors)
                })
            );

            const threshold = 0.6
            const faceMatcher = new faceapi.FaceMatcher(labeledFaceDescriptors, threshold)

            const results = faceDescriptions.map(fd => faceMatcher.findBestMatch(fd.descriptor))

            console.log(results);
            results.forEach((bestMatch, i) => {
                //const box = faceDescriptions[i].detection.box
                const text = bestMatch.toString()
                //const drawBox = new faceapi.draw.DrawBox(box, { label: text })
                //drawBox.draw(canvas)
                console.log(text, "dfdsfdsf");
                if (text.includes("unknown")) {
                    mensajeError();
                } else {
                    mensajeExito();
                }
            })

        }
    </script>

@endsection