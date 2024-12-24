@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="card-header">
    <div class="row">
      <div class="col-10">
        <h4 class="card-title m-0 font-weight-bold">
          <i class="fa fa-user"></i>{{ isset($JobOffer) ? 'Editar' : 'Añadir' }} nueva oferta de trabajo: 
        </h4>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-sm-12 form-content">
        <form action="{{ isset($JobOffer) ? route('JobOffers.update', $JobOffer) : route('JobOffers.store') }}" method="POST">
          @csrf
          @if(isset($JobOffer)) 
            @method('PUT') 
          @endif
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="first_name" class="morado">Title:</label>
                <input type="text" name="title" value="{{ old('title', $JobOffer->title ?? '') }}">
                @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="description" class="morado">Descriptión:</label>
                <input type="text" name="description" value="{{ old('description', $JobOffer->description ?? '') }}">
                @if ($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="Company" class="morado">Company:</label>
                <input type="text" name="Company" value="{{ old('Company', $JobOffer->Company ?? '') }}">
                @if ($errors->has('Company'))
                    <span class="text-danger">{{ $errors->first('Company') }}</span>
                @endif
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="idApplyStatus" class="morado">Apply Status:</label>
                <input type="text" name="idApplyStatus" value="{{ old('idApplyStatus', $JobOffer->idApplyStatus ?? '') }}">
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="idPriority" class="morado">Priority:</label>
                <input type="text" name="idPriority" value="{{ old('idPriority', $JobOffer->idPriority ?? '') }}">
                @if ($errors->has('idPriority'))
                    <span class="text-danger">{{ $errors->first('idPriority') }}</span>
                @endif
              </div>
            </div>

          </div>
          <div class="row">
            <div class="col-12 text-center">
              <div class="form-group">
                <button id="addJobOffer" class="btn btn-primary"> {{ isset($JobOffer) ? 'Actualizar' : 'Añadir' }}  </button>
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