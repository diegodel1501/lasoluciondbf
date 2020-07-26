@extends ('index')
@section('contenido')
<div class="row">
	<div class="col col-lg-6 col-md-6  col-xs-6">
		<h3>Editar Categoria: {{$categoria->nombre}}</h3>
		@if(count($errors)>0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{$error}}</li>
				@endforeach
			</ul>
		</div>
		@endif
		{!! Form::model($categoria,['method'=>'PUT','route'=>['categoria.update',$categoria->idcategoria]]) !!}
			{{Form::token()}}
			<div class="form-group">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" class="form-control" value="{{$categoria->nombre}}">
			</div>
			<div class="form-group">
				<label for="descripcion">descripcion</label>
				<input type="text" name="descripcion" class="form-control"  value="{{$categoria->descripcion}}">
			</div>
			<div class="form-group">
				<button class="btn btn-primary" class="form-control" type="submit">guardar</button>
				<a href="{{route('categoria.index')}}" class="btn btn-danger">cancelar</a>
			</div>
		{!! Form::close() !!}
	</div>
</div>
@endsection