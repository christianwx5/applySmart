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
      grid-template-columns: 0.5fr 2.5fr 2.8fr 1fr 2fr 2fr 1fr;
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
      /* Ajusta el valor según tus necesidades */
      margin: 0 auto;
      padding: 20px;
    }

    .row {
      margin-right: 0;
      margin-left: 0;
    }

    .form-group {
      margin-bottom: 20px;
      /* Ajusta el espacio entre los campos de entrada */
    }

    .form-group input {
      width: 100%;
      /* Ajusta el tamaño de los campos de entrada */
      max-width: 300px;
      /* Ajusta el valor según tus necesidades */
      box-sizing: border-box;
      /* Asegura que el padding y el borde se incluyan en el ancho total del elemento */
    }

    /* Estilos para el formulario */
    .card-body {
      background-color: #f8f9fa;
      /* Color de fondo del formulario */
      border: 1px solid #dee2e6;
      /* Borde del formulario */
      border-radius: 8px;
      /* Bordes redondeados */
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      /* Sombra */
      padding: 20px;
      /* Relleno interno */
    }
  </style>
  <title>Apply Smart</title>
</head>

<body>
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
              <!-- <div class="col-sm-4">
                <div class="form-group">
                  <label for="last_name" class="morado">Telefono:</label>
                </div>
              </div> -->
            </div>
            <div class="row">
              <div class="col-12 text-center">
                <div class="form-group">
                  <button id="addJobOffer" class="btn btn-primary"> Añadir </button>
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
            Se sobrepaso el límite de licencias registrada, el máximo es de, favor contáctese con su gestor.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>