@extends('layouts.app')

@section('content')

<style>

  .grid-container {
    display: grid;
    grid-template-columns: 0.5fr 2.5fr 2.5fr 2.5fr 2fr 2fr;
    gap: 10px;
    padding: 10px;
  }

  .grid-item {
    border: 1px solid #ccc;
    padding: 10px;
    background-color: #f9f9f9;
    text-align: center;
  }

</style>
<div class="container-fluid">
    <div class="card-header">
      <div class="row">
        <div class="col-10">
          <h4 class="card-title m-0 font-weight-bold">
            <i class="fa fa-building"></i>Listado de Empresas:
          </h4>
        </div>
        <div class="col-2 text-right">
          <a href="{{ route('companies.create') }}" class="btn btn-primary">Añadir Empresa</a>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="grid-container">
        <div class="grid-item header">ID</div>
        <div class="grid-item header">Nombre</div>
        <div class="grid-item header">País</div>
        <div class="grid-item header">Tipo</div>
        <div class="grid-item header">Importancia</div>
        <div class="grid-item header">Acciones</div>
        @foreach ($companies as $company)
        <div class="grid-item">
          <span class="status-circle 
            @if($company->status == 1) 
                status-active
            @elseif($company->status == 0) 
                status-inactive
            @elseif($company->status == 2) 
                status-deleted
            @endif">
            {{ $company->id }}
          </span>
        </div>
        <div class="grid-item">{{ $company->name }}</div>
        <div class="grid-item">{{ $company->country }}</div>
        <div class="grid-item">{{ $company->type }}</div>
        <div class="grid-item">{{ $company->importance }}</div>
        <div class="grid-item">
          <div class="btn-group">
            <a href="{{ route('companies.edit', $company) }}" class="btn btn-primary btn-sm">Editar</a>
            @if ($company->status == 1)
            <form action="{{ route('companies.desactivate', $company) }}" method="POST" style="display:inline-block;">
              @csrf
              @method('PATCH')
              <button type="submit" class="btn btn-warning btn-sm">Desactivar</button>
            </form>
            @elseif ($company->status == 0 || $company->status == 2)
            <form action="{{ route('companies.activate', $company) }}" method="POST" style="display:inline-block;">
              @csrf
              @method('PATCH')
              <button type="submit" class="btn btn-success btn-sm">Activar</button>
            </form>
            @endif
            @if ($company->status != 2)
            <form action="{{ route('companies.destroy', $company) }}" method="POST" style="display:inline-block;">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
            </form>
            @endif
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
  @endsection