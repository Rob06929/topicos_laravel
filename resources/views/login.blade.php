<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        #overlay, .overlay {
            position: absolute;
            top: 0;
            left: 0;
            }
        </style>
    <title>Document</title>
</head>
<body>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 login-alert1 hidden" role="alert">
            <p class="font-bold">Inicio de sesión correcto</p>
            <p>Su cuenta ha sido verificada y se ha iniciado sesión correctamente.</p>
            </div>
            <div class="bg-red-100 border-l-4 border-green-500 text-green-700 p-4 login-alert2 hidden" role="alert">
            <p class="font-bold">Error foto no coincide</p>
            <p>Su cuenta no ha sido verificada y no se ha iniciado sesión correctamente.</p>
            </div>
            <div class="min-h-screen bg-gray-100 flex flex-col justify-center sm:py-12">
            <div class="p-10 xs:p-0 mx-auto md:w-full mt-4">
                <div class="bg-white shadow w-full rounded-lg divide-y divide-gray-200">
                <div class="px-5 py-7">
                    <h2 class="text-center font-bold text-gray-700 text-2xl">Iniciar sesión</h2>
                    <form class="mt-7" action="#" method="POST" id="formulario">
                    <label class="font-semibold text-sm text-gray-600 pb-1 block">Nombre de usuario</label>
                    <input type="text" name="username" id="username" class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full focus:outline-none focus:shadow-outline-blue" placeholder="Escribe tu nombre de usuario" autofocus />

                    <label class="font-semibold text-sm text-gray-600 pb-1 block">Contraseña</label>
                
                    <input type="file" id="image" name="image" class="border rounded w-full py-2 px-3" onchange="document.getElementById('originalImg').src = window.URL.createObjectURL(this.files[0])">
                    <h2 class="font-bold text-gray-700 mb-2">Vista previa:</h2>
                    <img src="/images/joven2.jpg" id="originalImg" class="h-48 w-auto object-contain bg-gray-300" width="1400" height="800">
                    <canvas id="reflay" class="overlay" hidden ></canvas>

                    <button type="submit" id="envio" class="transition duration-500 ease-in-out bg-blue-500 hover:bg-blue-600 transform hover:-translate-y-1 hover:scale-110 text-white font-bold py-2 px-4 rounded-full w-full max-w-xs mx-auto mt-5">Iniciar sesión</button>
                    </form>
                </div>
            </div>
            </div>
            </div>





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
            var nombre_usuario="evo";
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');



            function procesarDatos(){
                let username=document.getElementById("username");
                console.log(username.value);

                const xhr = new XMLHttpRequest();
                const url = 'http://127.0.0.1:8000/verificar';
                const data = JSON.stringify({ username: username.value});

                xhr.open('POST', url, true);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);


                xhr.onload = function() {
                if (this.status === 200) {
                    const response = JSON.parse(this.responseText);
                    console.log(response);
                    nombre_usuario=response.url;
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

        reader.addEventListener('load', function () {
            preview.src = reader.result;
        }, false);

        if (file) {
            reader.readAsDataURL(file);
        }
    }

    function mensajeExito(){
        const loginAlert = document.querySelector('.login-alert1');
        loginAlert.classList.remove('hidden');
        //loginAlert.classList.add('opacity-0');
    }

    function mensajeError(){
        const loginAlert = document.querySelector('.login-alert2');
        loginAlert.classList.remove('hidden');
        
        //loginAlert.classList.add('opacity-0');
       
    }

    async function face(){
        const MODEL_URL = './models'

        await faceapi.loadSsdMobilenetv1Model(MODEL_URL)
        await faceapi.loadFaceLandmarkModel(MODEL_URL)
        await faceapi.loadFaceRecognitionModel(MODEL_URL)
        await faceapi.loadFaceExpressionModel(MODEL_URL)

        const img= document.getElementById('originalImg')
        let faceDescriptions = await faceapi.detectAllFaces(img).withFaceLandmarks().withFaceDescriptors().withFaceExpressions()
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
                
                const faceDescription = await faceapi.detectSingleFace(img1).withFaceLandmarks().withFaceDescriptor()
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
            console.log(text,"dfdsfdsf");
            if (text.includes("unknown")) {
                mensajeError();
            }else{
                mensajeExito();
            }
        })

    }

    
</script>

</body>
</html>

<!--<html>
    <head>
        <title>Face App</title>
        <style>
        #overlay, .overlay {
            position: absolute;
            top: 0;
            left: 0;
            }
        </style>
        <link rel="stylesheet" href="css/app.css">
    </head>
    <body>
        <img src="/images/joven2.jpg" id="originalImg" width="1400" height="800" />
        <canvas id="reflay" class="overlay"></canvas>

        <script src="/js/jquery-2.1.1.min.js"></script>

        <script src="/js/face-api.js"></script>
        <script src="/js/faceSystem.js"></script>
    </body>
</html>-->



