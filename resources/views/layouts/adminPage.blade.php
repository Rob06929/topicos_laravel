<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>Página de Bienvenida</title>
        @yield('header')

        <script src="https://cdn.tailwindcss.com"></script>


    </head>
    <body class="">


      <nav class="fixed h-20 top-0 z-50 w-full dark:bg-gray-800 dark:border-gray-700 ">
         <div class="bg-green-800 h-full px-3 pb-3 lg:px-5 lg:pl-3 shadow-lg" style="border-bottom-right-radius: 3rem; border-bottom-left-radius: 3rem;">
           <div class="flex items-center justify-between">
             <div class="flex items-center justify-start">

               <a href="#" class="flex ml-2 md:mr-24">
                  <img src="img/escudo2.png"  width="200" height="300"  alt="escudo de santa cruz de la sierra">
               </a>
             </div>
             <div class="flex items-center mr-4">
                   <div>
                     <a type="button" href="{{ route('logout') }}" class="flex text-sm justify-center items-center" aria-expanded="false">
                        <div class="p-3 text-gray-100 text-2xl">Log Out</div>
                        <svg class="w-10 h-10 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                           <path stroke="currentColor" stroke-linecap="round" width="100" height="90" stroke-linejoin="round" stroke-width="2" d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"></path>
                       </svg>
                     </a>

                   </div>
                
               </div>
           </div>
         </div>
       </nav>
       
       <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 mt-4 transition-transform -translate-x-full bg-white translate-x-0" aria-label="Sidebar">
          <div class="h-full py-3 pr-4 overflow-y-auto bg-green-700" style="border-bottom-right-radius: 1rem; border-top-right-radius: 1rem;">
            <ul class="pl-4 space-y-2 font-medium">
               <li class="flex flex-col bg-white rounded-lg items-center">
                  <div ><img class="rounded-lg p-1" src="{{$usuario->url_foto}}" alt=""></div>
                  <p>Nombre: {{$persona->nombre}}</p>
                  <p>Email: {{$usuario->email}}</p>
                  <p>Area: {{$tipo->nombre}}</p>


               </li>
               <li>
                  <a href="{{ route('inicio') }}" class="flex items-center p-2 hover:text-gray-900 rounded-lg hover:bg-green-100 text-gray-100 group">
                     <span class="ml-3">Inicio</span>
                  </a>
               </li>
               <li>
                  <a href="{{ route('lista_denuncias') }}" class="flex items-center p-2 hover:text-gray-900 rounded-lg hover:bg-green-100 text-gray-100 group">
                     <span class="ml-3">Denuncias</span>
                  </a>
               </li>
               <li>
                  <a href="#" class="flex items-center p-2 hover:text-gray-900 rounded-lg hover:bg-green-100 text-gray-100 group">
                     <span class="ml-3">Areas</span>
                  </a>
               </li>
               <li>
                  <a href="#" class="flex items-center p-2 hover:text-gray-900 rounded-lg hover:bg-green-100 text-gray-100 group">
                     <span class="ml-3">Tipos</span>
                  </a>
               </li>
               <li>
                  <a href="#" class="flex items-center p-2 hover:text-gray-900 rounded-lg hover:bg-green-100 text-gray-100 group">
                     <span class="ml-3">Mapa</span>
                  </a>
               </li>
            </ul>
          </div>
       </aside>
       
       <div class="p-4 sm:ml-64 h-screen">


            @yield('content')


       </div>
       

        @yield("script")
    </body>
</html>


      
          
      







  
</body>
</html>