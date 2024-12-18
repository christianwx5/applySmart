<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

  <!-- Styles -->
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

    .header {
      font-weight: bold;
      background-color: #ddd;
    }

    html,
    body {
      background-color: #fff;
      color: #636b6f;
      font-family: 'Nunito', sans-serif;
      font-weight: 200;
      height: 100vh;
      margin: 0;
    }

    .full-height {
      height: 100vh;
    }

    .flex-center {
      align-items: center;
      display: flex;
      justify-content: center;
    }

    .position-ref {
      position: relative;
    }

    .top-right {
      position: absolute;
      right: 10px;
      top: 18px;
    }

    .content {
      text-align: center;
    }

    .title {
      font-size: 50px;
    }

    .links>a {
      color: #636b6f;
      padding: 0 25px;
      font-size: 13px;
      font-weight: 600;
      letter-spacing: .1rem;
      text-decoration: none;
      text-transform: uppercase;
    }

    .m-b-md {
      margin-bottom: 30px;
    }

    /* Estilos añadidos */
    .container-fluid {
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }

    .row {
      margin-right: 0;
      margin-left: 0;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group input {
      width: 100%;
      max-width: 300px;
      box-sizing: border-box;
    }

    .card-body {
      background-color: #f8f9fa;
      border: 1px solid #dee2e6;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 20px;
    }
  </style>
  <title>ApplySmart</title>
</head>

<body>
  <div class="container-fluid">
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
        <div class="grid-item">{{ $jobOffer->id }}</div>
        <div class="grid-item">{{ Str::limit($jobOffer->title, 20, '...') }}</div>
        <div class="grid-item">{{ Str::limit($jobOffer->description, 20, '...') }}</div>
        <div class="grid-item">{{ $jobOffer->createdAt }}</div>
        <div class="grid-item">{{ $jobOffer->Company }}</div>
        <div class="grid-item">{{ $jobOffer->idApplyStatus }}</div>
        <div class="grid-item">{{ $jobOffer->idPriority }}</div>
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
          <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-warning" id="inactivateButton">Inactivar</button>
            <button type="button" class="btn btn-success" id="activateButton">Activar</button>
            <button type="submit" class="btn btn-danger">Eliminar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var deleteModal = document.getElementById('deleteModal');
      deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Botón que activó el modal
        var jobId = button.getAttribute('data-id'); // Extraer la información de atributos data-*
        var jobTitle = button.getAttribute('data-title'); // Extraer el título de jobOffer
        var deleteForm = document.getElementById('deleteForm');
        var inactivateButton = document.getElementById('inactivateButton');
        var activateButton = document.getElementById('activateButton');
        
        // Actualizar el contenido del modal con el título de jobOffer
        document.getElementById('jobOfferTitle').textContent = jobTitle;

        // Actualizar la acción del formulario de eliminación
        var deleteAction = '{{ route('JobOffers.destroy', ':id') }}';
        deleteAction = deleteAction.replace(':id', jobId);
        deleteForm.setAttribute('action', deleteAction);

        // Configurar la acción del botón de inactivación
        var inactivateAction = '{{ route('JobOffers.inactivate', ':id') }}'; // Ajustar con la ruta correcta de inactivación
        inactivateAction = inactivateAction.replace(':id', jobId);
        inactivateButton.onclick = function() {
          deleteForm.setAttribute('action', inactivateAction);
          deleteForm.submit();
        };

        // Configurar la acción del botón de activación
        var activateAction = '{{ route('JobOffers.activate', ':id') }}'; // Ajustar con la ruta correcta de activación
        activateAction = activateAction.replace(':id', jobId);
        activateButton.onclick = function() {
          deleteForm.setAttribute('action', activateAction);
          deleteForm.submit();
        };
      });
    });
  </script>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>

