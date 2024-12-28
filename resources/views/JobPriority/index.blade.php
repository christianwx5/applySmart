@extends('layouts.app')

@section('content')
<style>
  .grid-container {
    display: grid;
    grid-template-columns: 0.5fr 2fr 3fr 1fr 1.5fr;
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
                    <i class="fa fa-tasks"></i> Listado de Prioridades:
                </h4>
            </div>
            <div class="col-2 text-right">
                <a href="{{ route('jobPriorities.create') }}" class="btn btn-primary">Añadir Prioridad</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="grid-container">
            <div class="grid-item header">ID</div>
            <div class="grid-item header">Nombre</div>
            <div class="grid-item header">Descripción</div>
            <div class="grid-item header">Valor</div>
            <div class="grid-item header">Acciones</div>
            @foreach ($priorities as $priority)
            <div class="grid-item">
                <span class="status-circle 
                    @if($priority->status == 1) 
                        status-active
                    @elseif($priority->status == 0) 
                        status-inactive
                    @elseif($priority->status == 2) 
                        status-deleted
                    @endif">
                    {{ $priority->id }}
                </span>
            </div>
            <div class="grid-item">{{ $priority->name }}</div>
            <div class="grid-item">{{ $priority->description }}</div>
            <div class="grid-item">{{ $priority->value }}</div>
            <div class="grid-item">
                <div class="btn-group">
                    <a href="{{ route('jobPriorities.edit', $priority) }}" class="btn btn-primary btn-sm">Editar</a>
                    @if ($priority->status == 1)
                    <form action="{{ route('jobPriorities.desactivate', $priority) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-warning btn-sm">Desactivar</button>
                    </form>
                    @elseif ($priority->status == 0 || $priority->status == 2)
                    <form action="{{ route('jobPriorities.activate', $priority) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success btn-sm">Activar</button>
                    </form>
                    @endif
                    @if ($priority->status != 2)
                    <form action="{{ route('jobPriorities.destroy', $priority) }}" method="POST" style="display:inline-block;">
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
