

@extends('layouts.app')

@section('content')
  <style>
    .grid-container {
      display: grid;
      grid-template-columns: 0.5fr 2.5fr 2.8fr 1fr 2fr 2fr 1fr 1fr 1fr;
      gap: 10px;
      padding: 10px;
    }

    .grid-item {
      border: 1px solid #ccc;
      padding: 10px;
      background-color: #f9f9f9;
    }
  </style>

@php
  $applyStatuses = ['Deseos', 'A postular', 'Postulado', 'Contactado', '1era entrevista', 'Tecn entrevista', 'Tecn prueba', 'Sipco entrevista', 'Sipco prueba', 'Final entrevista', 'Contratado', 'Rechazado', 'Anulado', 'Postorgado' ,'No contactado']
@endphp

  <div class="container">
    <div class="card-header">
      <div class="row">
        <div class="col-10">
          <h4 class="card-title m-0 font-weight-bold">
            <i class="fa fa-user"></i>Listado de ofertas de trabajo:
          </h4>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="row mb-3">
        <div class="col-2">
          <a href="{{ route('JobOffers.create') }}">
            <button id="btnRegister" class="btn btn-primary">Registrar nuevo</button>
          </a>
        </div>
      </div>
      <div class="grid-container">
        <div class="grid-item header">ID</div>
        <div class="grid-item header">TITLE</div>
        <div class="grid-item header">DESCRIPCION</div>
        <div class="grid-item header">CREATED AT</div>
        <div class="grid-item header">COMPANY</div>
        <div class="grid-item header">APPLY STATUS</div>
        <div class="grid-item header">PRIORITY</div>
        <div class="grid-item header">EDITAR</div>
        <div class="grid-item header">ELIMINAR</div>
        @foreach ($jobOffers as $jobOffer)
        <div class="grid-item">
          <span class="status-circle 
                    @if($jobOffer->status == 1) 
                        status-active
                    @elseif($jobOffer->status == 0) 
                        status-inactive
                    @elseif($jobOffer->status == 2) 
                        status-deleted
                    @endif">
            {{ $jobOffer->id }}
          </span>
        </div>
        <div class="grid-item">{{ Str::limit($jobOffer->title, 20, '...') }}</div>
        <div class="grid-item">{{ Str::limit($jobOffer->description, 20, '...') }}</div>
        <div class="grid-item">{{ $jobOffer->createdAt }}</div>
        <div class="grid-item">
          <select class="form-control">
            @foreach ($companies as $company)
            <option value="{{ $company->id }}" @if($jobOffer->idCompany == $company->id) selected @endif>{{ $company->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="grid-item">
          <select class="form-control">
            @foreach ($applyStatuses as $index => $applyStatus)
              <option value="{{ $index }}" @if($jobOffer->idApplyStatus == $index) selected @endif>{{ $applyStatus }}</option>
            @endforeach
            {{ $jobOffer->idApplyStatus }}
          </select>
        </div>
        <div class="grid-item">
          <select class="form-control">
            @foreach ($jobPriorities as $priority)
              <option value="{{ $priority->id }}" @if($jobOffer->idPriority == $priority->id) selected @endif>{{ $priority->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="grid-item">
          <a href="{{ route('JobOffers.edit', $jobOffer) }}" class="btn btn-primary btn-sm">Editar</a>
        </div>
        <div class="grid-item">
          <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="{{ $jobOffer->id }}" data-title="{{ $jobOffer->title }}">Eliminar</button>
        </div>
        @endforeach
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Confirmar acción</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ¿Desea eliminar o inactivar <span id="jobOfferTitle"></span>?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

          <form id="deleteForm" method="POST">
            <button type="button" class="btn btn-warning" id="inactivateButton">Inactivar</button>
            <button type="button" class="btn btn-success" id="activateButton">Activar</button>
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Eliminar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      console.log("DOMContentLoaded event fired");

      var deleteModal = $('#deleteModal'); // Usar jQuery para seleccionar el modal

      deleteModal.on('show.bs.modal', function(event) {
        console.log("show.bs.modal event fired");

        var button = $(event.relatedTarget); // Botón que activó el modal
        var jobId = button.data('id'); // Extraer la información de atributos data-*
        var jobTitle = button.data('title'); // Extraer el título de jobOffer
        var deleteForm = $('#deleteForm'); // Usar jQuery para seleccionar el formulario
        var inactivateButton = $('#inactivateButton');
        var activateButton = $('#activateButton');

        // Actualizar el contenido del modal con el título de jobOffer
        $('#jobOfferTitle').text(jobTitle);

        // Actualizar la acción del formulario de eliminación
        var deleteAction = "{{ route('JobOffers.destroy', ':id') }}";
        deleteAction = deleteAction.replace(':id', jobId);
        deleteForm.attr('action', deleteAction);

        // Configurar la acción del botón de inactivación
        var inactivateAction = "{{ route('JobOffers.inactivate', ':id') }}";
        inactivateAction = inactivateAction.replace(':id', jobId);
        inactivateButton.off('click').on('click', function() {
          console.log("inactivateButton clicked");

          deleteForm.attr('action', inactivateAction);
          deleteForm.attr('method', 'POST');
          $('<input>').attr({
            type: 'hidden',
            name: '_method',
            value: 'PATCH'
          }).appendTo(deleteForm);
          deleteForm.submit();
        });

        // Configurar la acción del botón de activación
        var activateAction = "{{ route('JobOffers.activate', ':id') }}";
        activateAction = activateAction.replace(':id', jobId);
        activateButton.off('click').on('click', function() {
          console.log("activateButton clicked");

          deleteForm.attr('action', activateAction);
          deleteForm.attr('method', 'POST');
          $('<input>').attr({
            type: 'hidden',
            name: '_method',
            value: 'PATCH'
          }).appendTo(deleteForm);
          deleteForm.submit();
        });

        // Configurar la acción del botón de eliminación
        deleteForm.off('submit').on('submit', function() {
          console.log("deleteForm submitted");
          deleteForm.attr('method', 'POST');
        });
      });
    });
  </script>



  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
@endsection