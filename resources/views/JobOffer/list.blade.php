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

    html, body 
    {
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

    .links > a {
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
  </style>
  <title>ApplySmart</title>
</head>
<body>
  <div class="container">
    <div class="title m-b-md">
      Listado de ofertas de trabajo:
    </div>
    <div class="col-2">
      <a href="{{ route('JobOffers.create') }}">
        <button id="btnRegister" class="btn btn-primary"> Registrar nuevo </button>
      </a>
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
      @foreach ( $jobOffers as $jobOffer)
        <div class="grid-item">{{ $jobOffer->id }}</div>
        <div class="grid-item">{{ Str::limit($jobOffer->title, 20, '...') }}</div>
        <div class="grid-item">{{ Str::limit($jobOffer->description, 20, '...') }}</div>
        <div class="grid-item">{{ $jobOffer->createdAt }}</div>
        <div class="grid-item">{{ $jobOffer->Company }}</div>
        <div class="grid-item">{{ $jobOffer->idApplyStatus }}</div>
        <div class="grid-item">{{ $jobOffer->idPriority }}</div>
        <div class="grid-item">
          <a href="{{ route('JobOffers.edit', $jobOffer) }}" class="btn btn-primary btn-sm">
            Editar
          </a>
        </div>
        <div class="grid-item">          
          <form action="{{ route('JobOffers.destroy', $jobOffer) }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="submit" value="Eliminar" class="btn btn-sm btn-danger" onclick="return confirm('¿Desea eliminar...?')">
          </form>
        </div>

      @endforeach
    </div>
  </div>
</body>
</html>
