@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card-header">
        <div class="row">
            <div class="col-10">
                <h4 class="card-title m-0 font-weight-bold">
                    <i class="fa fa-tasks"></i>{{ isset($jobPriority) ? 'Editar' : 'Añadir' }} nueva Prioridad:
                </h4>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 form-content">
                <form action="{{ isset($jobPriority) ? route('jobPriorities.update', $jobPriority) : route('jobPriorities.store') }}" method="POST">
                    @csrf
                    @if(isset($jobPriority))
                    @method('PUT')
                    @endif
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="name" class="morado">Nombre:</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $jobPriority->name ?? '') }}" required>
                                @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="description" class="morado">Descripción:</label>
                                <textarea name="description" class="form-control">{{ old('description', $jobPriority->description ?? '') }}</textarea>
                                @if ($errors->has('description'))
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="value" class="morado">Valor:</label>
                                <input type="number" name="value" class="form-control" value="{{ old('value', $jobPriority->value ?? '') }}" required>
                                @if ($errors->has('value'))
                                <span class="text-danger">{{ $errors->first('value') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="form-group">
                                <button id="addPriority" class="btn btn-primary"> {{ isset($jobPriority) ? 'Actualizar' : 'Añadir' }} </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="maxUserModal" tabindex="-1" role="dialog" aria-labelledby="maxUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="maxUserModalLabel">Mensaje</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    content
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
