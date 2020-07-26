@extends ('index')
@section('contenido')
<div class="row">
	<div class="col col-lg-6 col-md-6  col-xs-6">
		<h3>Editar Insumo: {{$insumo->nombre}}</h3>
			@if(count($errors)>0)
								<div class="alert alert-danger">
									<ul>

										@foreach ($errors->all() as $error)
										@if($error!='El campo idinsumo debe ser un numero.')
										<li>{{$error}}</li>
										@else
										<li>Seleccione un insumo a ingresar</li>
										@endif
										@endforeach
									</ul>
								</div>
								@endif
{!! Form::model($insumo,['method'=>'PUT','route'=>['insumo.update',$insumo->idinsumo],'files'=>'true']) !!}
{{Form::token()}}
<div class="row">
	<div class="col-md-6 col-xs-12">
		<div class="form-group">
			<label for="nombre">Nombre</label>
			<input type="text" name="nombre" class="form-control" required value="{{$insumo->nombre}}">
		</div>
	</div>
	<div class="col-md-6 col-xs-12">
		<div class="form-group">
			<label for="descripcion">Descripcion</label>
			<input type="text" name="descripcion" class="form-control"  value="{{$insumo->descripcion}}">
		</div>
	</div>
		<div class="col-md-6 col-xs-12">
		<div class="form-group">
			<label for="stock">Stock</label>
			<input type="text" name="stock" class="form-control" value="{{$insumo->stock}}">
		</div>
	</div>
	<div class="col-md-4 col-xs-12">
		<div class="form-group">
			<label for="imagen">Imagen</label>
			<input type="file" name="imagen" class="form-control" >
		</div>
		@if($insumo->imagen!="")
		<img src="{{asset('imagenes/insumos/'.$insumo->imagen)}}" width="100px" height="100px">
		@endif
	</div>
</div>
<div class="row">
	<div class="col-md-6 col-xs-12">		
		<div class="form-group">
			<button class="btn btn-primary" class="form-control" type="submit">guardar</button>
			<a href="{{route('insumo.index')}}" class="btn btn-danger">cancelar</a>
		</div>
	</div>
</div>
{!! Form::close() !!}

@endsection