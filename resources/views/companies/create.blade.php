@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card-header">
        <div class="row">
            <div class="col-10">
                <h4 class="card-title m-0 font-weight-bold">
                    <i class="fa fa-building"></i>{{ isset($company) ? 'Editar' : 'Añadir' }} nueva empresa:
                </h4>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 form-content">
                <form action="{{ isset($company) ? route('companies.update', $company) : route('companies.store') }}" method="POST">
                    @csrf
                    @if(isset($company))
                    @method('PUT')
                    @endif
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="name" class="morado">Nombre de la Empresa:</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $company->name ?? '') }}" required>
                                @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="country" class="morado">País:</label>
                                <input type="text" name="country" class="form-control" value="{{ old('country', $company->country ?? '') }}">
                                @if ($errors->has('country'))
                                <span class="text-danger">{{ $errors->first('country') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="type" class="morado">Tipo:</label>
                                <input type="text" name="type" class="form-control" value="{{ old('type', $company->type ?? '') }}">
                                @if ($errors->has('type'))
                                <span class="text-danger">{{ $errors->first('type') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="importance" class="morado">Importancia:</label>
                                <input type="number" name="importance" class="form-control" value="{{ old('importance', $company->importance ?? '') }}" required>
                                @if ($errors->has('importance'))
                                <span class="text-danger">{{ $errors->first('importance') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="form-group">
                                <button id="addCompany" class="btn btn-primary"> {{ isset($company) ? 'Actualizar' : 'Añadir' }} </button>
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
