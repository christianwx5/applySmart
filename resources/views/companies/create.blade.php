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
            border: 1px solid #ccc;
            /* Añade un borde como en los campos de JobOffer */
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
    <title>Apply Smart</title>
</head>

<body>
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
</body>

</html>