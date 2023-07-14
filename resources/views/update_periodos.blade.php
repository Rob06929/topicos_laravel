@extends('layouts.adminPage2')

@section('header')
@endsection


@section('content')
<div class="flex items-center justify-center flex-col h-5/6 p-4 border-2 border-gray-200 border-dashed rounded-lg mt-20">

<div class=" p-6 bg-white rounded shadow-lg my-4">
    <h2 class="text-xl font-semibold mb-4">Periodo actualizar contraseña</h2>
    <form class="" method="POST" action="{{env('APP_URL')}}/api/actions/setPeriodo">
        <div class="flex flex-col items-center justify-center">
            <div class="mb-4 w-96">
                <input type="number" name="valor" class="mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1" placeholder="Ingrese un numero de días"  required/>
            </div>
            <button type="submit" class="p-3 bg-green-500 text-white font-semibold py-2 rounded">Enviar</button>
        </div>
        
    </form>
</div>
<div class=" p-6 bg-white rounded shadow-lg">
    <h2 class="text-xl font-semibold mb-4">Periodo confirmar Email</h2>
    <form method="POST" action="{{env('APP_URL')}}/api/actions/setConfirmation">
        @csrf
        <div class="flex flex-col items-center justify-center">
            <div class="mb-4 w-96">
                <input type="number" name="valor" class="mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1" placeholder="Ingrese un numero de minutos" required />
            </div>
            <button type="submit" class="p-3 bg-green-500 text-white font-semibold py-2 rounded">Enviar</button>
        </div>
    </form>
</div>

</div>
@endsection
@section('script')

@endsection

 