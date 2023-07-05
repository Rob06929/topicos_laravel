@extends('layouts.adminPage')

@section('header')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.css"  rel="stylesheet" />
@endsection


@section('content')
    <div class="flex items-center justify-center h-5/6 p-4 border-2 border-gray-200 border-dashed rounded-lg mt-20">
        <div>
            <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">Bienvenido <span class="text-green-600 dark:text-blue-500">{{$usuario->name}}</span>.</h1>
        </div>
    </div>

@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>
@endsection