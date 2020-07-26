@extends ('index')
@section('contenido')
<div class="row">
	<div class="col col-lg-6 col-md-6  col-xs-6">
		<h3>Editar Cliente: {{$persona->nombre}}</h3>
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
					{!! Form::model($persona,['method'=>'PUT','route'=>['cliente.update',$persona->idPersona]]) !!}
						{{Form::token()}}
						<div class="row">
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label for="nombre">Nombre</label>
									<input type="text" name="nombre" class="form-control" required value="{{$persona->nombre}}">
								</div>
							</div>
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label for="direccion">Direccion</label>
									<input type="text" name="direccion" class="form-control" required value="{{$persona->direccion}}">
								</div>
							</div><div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label for="documento">Documento</label>
									<input type="text" name="documento" class="form-control" required value="{{$persona->documento}}">
								</div>
							</div>
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label for="email">E-mail</label>
									<input type="email" name="email" class="form-control" required value="{{$persona->email}}">
								</div>
							</div>
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label for="telefono">Telefono</label>
									<input type="text" name="telefono" class="form-control" value="{{$persona->telefono}}">
								</div>
							</div>
							</div>
						</div>


					</div>


				</div><!-- /.row -->
				<div class="row">	
	<div class="col-md-6 col-xs-12">		
		<div class="form-group">
			<button class="btn btn-primary" class="form-control" type="submit">guardar</button>
			<a href="{{route('cliente.index')}}" class="btn btn-danger">cancelar</a>
		</div>
	</div>
	{!! Form::close() !!}

	<!--Fin Contenido-->
</div>

@endsection