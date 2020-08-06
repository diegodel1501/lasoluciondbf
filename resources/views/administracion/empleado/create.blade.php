@extends ('index')
@section('contenido')

	
						<!--Contenido-->
						<div class="row">
							<div class="col col-lg-6 col-md-6  col-xs-6">
								<h3>Nuevo Empleado</h3>
								@if(count($errors)>0)
							<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{$error}}</li>
				@endforeach
			</ul>
		</div>
								@endif
							</div>
						</div>
						{!! Form::open(array('url'=>'empleado','method'=>'POST','autocomplete'=>'off')) !!}
						{{Form::token()}}
						<div class="row">
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label for="nombre">Nombre</label>
									<input type="text" name="nombre" class="form-control" required value="{{old('nombre')}}">
								</div>
							</div>
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label for="direccion">Direccion</label>
									<input type="text" name="direccion" class="form-control" required value="{{old('direccion')}}">
								</div>
							</div>
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label for="documento">Documento</label>
									<input type="text" name="documento" class="form-control" required value="{{old('documento')}}">
								</div>
							</div>
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label for="email">E-mail</label>
									<input type="email" name="email" class="form-control" required value="{{old('email')}}">
								</div>
							</div>
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label for="telefono">Telefono</label>
									<input type="text" name="telefono" class="form-control" value="{{old('telefono')}}">
								</div>
							</div>
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label for="tipo_persona">Tipo de Empleado</label>
									<select name="tipo_persona" required class="form-control">
										<option value="">seleccione</option>
										<option value="panadero">Panadero</option>
										<option value="vendedor">Vendedor</option>
									</select>
								</div>

							</div>
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label for="password">Contraseña</label>
									<input type="password" name="password" class="form-control" required >
								</div>
							</div>
							</div>
						</div>


					</div>


<div class="row ">	
	<div class="col-md-6 col-xs-12">		
		<div class="form-group">
			<button class="btn btn-primary" class="form-control" type="submit">guardar</button>
			<a href="{{route('empleado.index')}}" class="btn btn-danger">cancelar</a>
		</div>
	</div>
	{!! Form::close() !!}

	<!--Fin Contenido-->
</div>

@endsection



