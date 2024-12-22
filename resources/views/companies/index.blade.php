<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

  <!-- Styles -->
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

    .header {
      font-weight: bold;
      background-color: #ddd;
      text-align: center;
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

    .btn-group {
      display: flex;
      justify-content: center;
      gap: 5px;
    }

    /* Estilos añadidos */
    .status-circle {
      display: inline-block;
      width: 30px;
      height: 30px;
      line-height: 30px;
      border-radius: 50%;
      text-align: center;
      color: white;
      font-weight: bold;
    }

    .status-active {
      background-color: green;
    }

    .status-inactive {
      background-color: gray;
    }

    .status-deleted {
      background-color: red;
    }

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

    /* Estilos para el formulario */
    .card-body {
      background-color: #f8f9fa;
      border: 1px solid #dee2e6;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 20px;
    }
  </style>

  <title>Listado de Empresas</title>
</head>

<body>
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
            <form action="{{ route('companies.deactivate', $company) }}" method="POST" style="display:inline-block;">
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
</body>

</html>
