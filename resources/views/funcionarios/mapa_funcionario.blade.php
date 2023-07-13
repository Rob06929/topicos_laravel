@extends('layouts.adminPage2')

@section('header')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
@endsection


@section('content')

    
      
<div class="flex items-center justify-center flex-col h-5/6 p-4 border-2 border-gray-200 border-dashed rounded-lg mt-20">
    <div class="mb-2">
        <ul id="lista-puntos" class="flex">
           
        </ul>
    </div>
    <div class="flex">
        <div class="ml-8 flex items-center">
            <div class="flex">
                <label for="opciones_estado" class="block text-gray-700">Estado</label>
                <select id="opciones_estado" class="border border-gray-300 rounded ml-1">
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
                <select id="opciones_tipo" class="border border-gray-300 rounded ml-1">
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
                <select id="opciones_periodo" class="border border-gray-300 rounded ml-1">
                    <option selected value="0">Todos</option>  
                    <option value="1">1 día</option>
                    <option value="7">7 días</option>
                    <option value="30">30 días</option>
                </select>
            </div>
        </div>
    </div>
    <div id="mapContainer" class="my-3 mx-8 border-2 border-neutral-950 rounded-lg shadow-2xl" style="width:1300px;height:700px;"></div>

    <!--<div class="ml-8 flex items-center">
        <div class="flex">
            <label for="opciones" class="block text-gray-700">Radio de busqueda</label>
            <select id="opciones_radio" name="opciones" class="border border-gray-300 rounded ml-1">
              <option value="100" selected>100 metros</option>
              <option value="500">500 metros</option>
              <option value="1000">1000 metros</option>
              <option value="1500">1500 metros</option>
              
            </select>
        </div>
        

    </div>-->

</div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>
    <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2iKcRjgOKH2Kzv1hqSCM18wan1a1cr68&callback=initMap&v=weekly"
    defer
    ></script>
    
    <script src="https://unpkg.com/@googlemaps/markerclusterer@2.0.2/dist/index.min.js"></script>
    
    
    
    
    <script>
    
    
    
    // Array de elementos para agregar a la lista
    
    const colores = {
      color1: "#FF0000", // Rojo
      color2: "#00FF00", // Verde
      color3: "#0000FF", // Azul
      color4: "#FFFF00", // Amarillo
      color5: "#FF00FF", // Magenta
      color6: "#00FFFF", // Cian
      color7: "#FFA500", // Naranja
      color8: "#800080", // Púrpura
      color9: "#008000", // Verde oscuro
      color10: "#000080" // Azul oscuro
    };
    // Rellenar la lista con elementos
    
    var tipos= {!! json_encode($tipos) !!};
    const lista = document.getElementById('lista-puntos');
    
    tipos.forEach(element => {
      const li = document.createElement('li');
        li.classList.add("flex","items-center","justify-center","px-4"); 
    
      const p = document.createElement('p');
      const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
      p.textContent = element.nombre;
      svg.setAttribute('width', '8');
      svg.setAttribute('height', '8');
      svg.innerHTML = `<circle cx="4" cy="4" r="4" fill="${colores["color"+element.id]}" />`;
      li.appendChild(svg);
      li.appendChild(p);
      lista.appendChild(li);
        console.log(element);
    });
    
    
        const selectTipo = document.getElementById('opciones_tipo');
        const selectEstado = document.getElementById('opciones_estado');
        const selectPeriodo = document.getElementById('opciones_periodo');
        
      
        
        // LOCATION IN LATITUDE AND LONGITUDE.
    
    
        function initMap() {
                  // MAP ATTRIBUTES.
            var center = new google.maps.LatLng(-17.78629,-63.18117 );     
    
            var mapAttr = {
                center: center,
                zoom: 15,
                mapTypeId: "satellite"
            };
    
            // THE MAP TO DISPLAY.
            var map = new google.maps.Map(document.getElementById("mapContainer"), mapAttr);
            var markers=[];
            var icon = {
                        path: "M-20,0a20,20 0 1,0 40,0a20,20 0 1,0 -40,0",
                        fillOpacity: 1,
                        anchor: new google.maps.Point(0,0),
                        strokeWeight: 0,
                        scale: 0.5
                    }
            var datos= {!! json_encode($denuncias) !!};
            // Iterar sobre el array en JavaScript
                for (var i = 0; i < datos.length; i++) {
                    icon.fillColor=colores["color"+datos[i]["id_tipo"]];
                        let pos={ lat: parseFloat(datos[i]["latitud"]), lng: parseFloat(datos[i]["longitud"]) };
                        const marker = new google.maps.Marker({
                            position: pos,
                            icon: icon,
                        });
            
                        markers.push(marker);
    
                        console.log(markers)
                }
                for (let i = 0; i < datos.length; i++) {
                let pos={ lat: parseFloat(datos[i]["latitud"]), lng: parseFloat(datos[i]["longitud"]) };

                const element = markers[i];
                const infowindow = new google.maps.InfoWindow({
                    content:`<div class="flex items-center justify-center flex-col p-4">
                                <div><span class="text-lg text-blue-600">${datos[i]["titulo"]}</span> - <span class="text-lg text-red-600">${datos[i]["nombre_estado"]}</span></div>
                                <div class="">descripcio de la denuncia</div>
                                <div ><span class="text-sm text-gray-400">${datos[i]["fecha_creacion"]}</span> - <span class="text-sm text-red-600">${datos[i]["nombre_tipo"]}</span></div>
                              </div>`,
                    ariaLabel: datos[i]["titulo"],
                });

                console.log(datos)
            

                markers[i].addListener("click", () => {
                    infowindow.open({
                    anchor: markers[i],
                    map,
                    });
                 });
            };
                console.log(markers);
        const markerCluster =new markerClusterer.MarkerClusterer({ map, markers });
    
        selectPeriodo.addEventListener('change', function() {
            markers.forEach(element => {
                element.setMap(null);
            });
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const url = 'http://localhost:8000/api/getFiltroDenunciasMap';
            const data = {
            type_id: selectTipo.value,
            state_id: selectEstado.value,
            num_days:selectPeriodo.value
            };
    
            fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(datos => {
                markerCluster.removeMarkers(markers);
                markers.forEach(element => {
                    element.setMap(null);
                });
                markers=[];
                for (var i = 0; i < datos.length; i++) {
                    console.log("color"+datos[i]["id_tipo"])
                    console.log(icon)
                    icon.fillColor=colores["color"+datos[i]["id_tipo"]];
                    let pos={ lat: parseFloat(datos[i]["latitud"]), lng: parseFloat(datos[i]["longitud"]) };
                    const marker = new google.maps.Marker({
                            position: pos,
                            map,
                            icon: icon,
                    });
                    markers.push(marker);
                        
                }
    
                for (let i = 0; i < datos.length; i++) {
                    let pos={ lat: parseFloat(datos[i]["latitud"]), lng: parseFloat(datos[i]["longitud"]) };
    
                    const element = markers[i];
                    const infowindow = new google.maps.InfoWindow({
                        content:`<div class="flex items-center justify-center flex-col p-4">
                                    <div><span class="text-lg text-blue-600">${datos[i]["titulo"]}</span> - <span class="text-lg text-red-600">${datos[i]["nombre_estado"]}</span></div>
                                    <div class="">descripcio de la denuncia</div>
                                    <div ><span class="text-sm text-gray-400">${datos[i]["fecha_creacion"]}</span> - <span class="text-sm text-red-600">${datos[i]["nombre_tipo"]}</span></div>
                                  </div>`,
                        ariaLabel: datos[i]["titulo"],
                    });
    
                    console.log(datos)
                
    
                    markers[i].addListener("click", () => {
                        infowindow.open({
                        anchor: markers[i],
                        map,
                        });
                     });
                };
    
                markerCluster.addMarkers(markers);
    
            })        
            .catch(error => {
                // Manejar errores
                console.error('Error:', error);
            });;
        });
    
        selectTipo.addEventListener('change', function() {
            markers.forEach(element => {
                element.setMap(null);
            });
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const url = 'http://localhost:8000/api/getFiltroDenunciasMap';
            const data = {
            type_id: selectTipo.value,
            state_id: selectEstado.value,
            num_days:selectPeriodo.value
            };
    
            fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(datos => {
                markerCluster.removeMarkers(markers);
                markers.forEach(element => {
                    element.setMap(null);
                });
                markers=[];
                for (var i = 0; i < datos.length; i++) {
                    console.log("color"+datos[i]["id_tipo"])
                    console.log(icon)
                    icon.fillColor=colores["color"+datos[i]["id_tipo"]];
                        let pos={ lat: parseFloat(datos[i]["latitud"]), lng: parseFloat(datos[i]["longitud"]) };
                        const marker = new google.maps.Marker({
                            position: pos,
                            map,
                            icon: icon,
                        });
            
                        markers.push(marker);
                        
                }
    
                for (let i = 0; i < datos.length; i++) {
                    let pos={ lat: parseFloat(datos[i]["latitud"]), lng: parseFloat(datos[i]["longitud"]) };
    
                    const element = markers[i];
                    const infowindow = new google.maps.InfoWindow({
                        content:`<div class="flex items-center justify-center flex-col p-4">
                                    <div><span class="text-lg text-blue-600">${datos[i]["titulo"]}</span> - <span class="text-lg text-red-600">${datos[i]["nombre_estado"]}</span></div>
                                    <div class="">descripcio de la denuncia</div>
                                    <div ><span class="text-sm text-gray-400">${datos[i]["fecha_creacion"]}</span> - <span class="text-sm text-red-600">${datos[i]["nombre_tipo"]}</span></div>
                                  </div>`,
                        ariaLabel: datos[i]["titulo"],
                    });
    
                    console.log(datos)
                
    
                    markers[i].addListener("click", () => {
                        infowindow.open({
                        anchor: markers[i],
                        map,
                        });
                     });
                };
                markerCluster.addMarkers(markers);
    
            })        
            .catch(error => {
                // Manejar errores
                console.error('Error:', error);
            });;
        });
    
        selectEstado.addEventListener('change', function() {
            markers.forEach(element => {
                element.setMap(null);
            });
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const url = 'http://localhost:8000/api/getFiltroDenunciasMap';
            const data = {
            type_id: selectTipo.value,
            state_id: selectEstado.value,
            num_days:selectPeriodo.value
            };
    
            fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(datos => {
                markerCluster.removeMarkers(markers);
                markers.forEach(element => {
                    element.setMap(null);
                });
                markers=[];
                for (var i = 0; i < datos.length; i++) {
                    console.log("color"+datos[i]["id_tipo"])
                    console.log(icon)
                    icon.fillColor=colores["color"+datos[i]["id_tipo"]];
                        let pos={ lat: parseFloat(datos[i]["latitud"]), lng: parseFloat(datos[i]["longitud"]) };
                        const marker = new google.maps.Marker({
                            position: pos,
                            map,
                            icon: icon,
                        });
            
                        markers.push(marker);
                        
                }
    
                for (let i = 0; i < datos.length; i++) {
                    let pos={ lat: parseFloat(datos[i]["latitud"]), lng: parseFloat(datos[i]["longitud"]) };
    
                    const element = markers[i];
                    const infowindow = new google.maps.InfoWindow({
                        content:`<div class="flex items-center justify-center flex-col p-4">
                                    <div><span class="text-lg text-blue-600">${datos[i]["titulo"]}</span> - <span class="text-lg text-red-600">${datos[i]["nombre_estado"]}</span></div>
                                    <div class="">descripcio de la denuncia</div>
                                    <div ><span class="text-sm text-gray-400">${datos[i]["fecha_creacion"]}</span> - <span class="text-sm text-red-600">${datos[i]["nombre_tipo"]}</span></div>
                                  </div>`,
                        ariaLabel: datos[i]["titulo"],
                    });
    
                    console.log(datos)
                
    
                    markers[i].addListener("click", () => {
                        infowindow.open({
                        anchor: markers[i],
                        map,
                        });
                     });
                };
                markerCluster.addMarkers(markers);
    
            })        
            .catch(error => {
                // Manejar errores
                console.error('Error:', error);
            });;
        });
    
        }
    
        window.initMap = initMap;
        </script>@endsection
