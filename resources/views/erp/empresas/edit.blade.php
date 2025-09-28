{{-- resources/views/empresas/edit.blade.php --}}
@extends('layouts.vuexy')

@section('title', 'Editar Empresa')

@section('content')

   <div class="row">
      <div class="col-12">
         <div class="card">
               <div class="card-header">
                  <h3 class="card-title">Editar Empresa: {{ $empresa->nombre }}</h3>
               </div>
               
               <form action="{{ route('empresas.update', $empresa) }}" method="POST">
                  @csrf
                  @method('PUT')
                  @include('erp.empresas.form')
               </form>
         </div>
      </div>
   </div>

@endsection