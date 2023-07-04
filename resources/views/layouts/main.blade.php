<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>Página de Bienvenida</title>
        @yield('header')

        <script src="https://cdn.tailwindcss.com"></script>

        <style>
            ul > li {
                display: inline-block;
                /* You can also add some margins here to make it look prettier */
            }   
        </style>
    </head>
    <body class="font-sans antialiased">

        <div class="relative flex justify-center items-center min-h-screen bg-center bg-gradient-to-r from-neutral-50 to-green-500">
            <div class="sm:fixed sm:top-0 sm:left-0 p-6 text-right">
                    <img src="img/escudo.png"  width="200" height="300"  alt="escudo de santa cruz de la sierra">
            </div>
    
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
                    @if ($dashboard==true)
                        <a href="{{route('welcome')}}" class=" mr-4 font-semibold text-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>

                    @endif
                    @if ($login==true)
                        <a href="{{route('login')}}" class="font-semibold text-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>
                    @endif
           
        
            </div>
    
            <div class="px-6 pt-10 mt-10">

                @yield('content')

            </div>
        </div>

        @yield("script")
    </body>
</html>


      
          
      







  
</body>
</html>