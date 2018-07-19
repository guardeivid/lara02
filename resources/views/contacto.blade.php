<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name=description content="">
	<meta name=viewport content="width=device-width, initial-scale=1">
	<title>Pagina de contacto</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-5">
				<h2>Enviar mensaje</h2>
				<form action="{{ route('contacto.store') }}" method="POST">
					<div class="form-group">
						<input class="form-control" type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Nombre" />
						{{ $errors->first('nombre') }}
					</div>
					<div class="form-group">
						<input class="form-control" type="text" name="email" value="{{ old('email') }}" placeholder="Email" />
						{{ $errors->first('email') }}
					</div>
					<div class="form-group">
						<textarea name="mensaje" class="form-control" placeholder="Mensaje">{{ old('mensaje') }}</textarea>
						{{ $errors->first('mensaje') }}
					</div>
					<!--<input type="hidden" name="_token" value="{{ csrf_token() }}"/>-->
					{{ csrf_field() }}	
					<div class="form-group">
						<input class="btn btn-primary" type="submit" value="Enviar Formulario"/>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>