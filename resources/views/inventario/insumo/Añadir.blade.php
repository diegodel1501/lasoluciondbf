@extends('index')
@section('contenido')
<div class="row">
	{!! Form::open(array('url'=>'insumo.add','method'=>'POST','autocomplete'=>'off')) !!}
	{{Form::token()}}
	<div class="col-md-12 col-xs-12">
		<div class="form-group">
			<label for="idinsumo">insumo</label>
			<select name="idinsumo" class="form-control selectpicker" data-live-search="true">
				<option value="seleccione" selected="selected"> seleccione </option>
				@foreach ($insumos as $i)
				<option value="{{$i->idinsumo}}"> {{$i->nombre}} </option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="col-md-6 col-xs-12">
		<div class="form-group">
			<label for="cantidad">Cantidad</label>
			<input type="number" name="cantidad" class="form-control" required value="{{old('cantidad')}}">
		</div>
	</div>
	<div class="col-md-6 col-xs-12">
		<div class="form-group">
			<label for="preciocompra">Precio de compra de la cantidad</label>
			<input type="number" name="preciocompra" class="form-control" required value="{{old('preciocompra')}}">
		</div>
	</div>

</div>
<div class="row">	
	<div class="col-md-6 col-xs-12">		
		<div class="form-group">
			<button class="btn btn-primary" class="form-control" type="submit">guardar</button>
			<a href="{{route('insumo.index')}}" class="btn btn-danger">cancelar</a>
		</div>

	</div>
	{!! Form::close() !!}

	<!--Fin Contenido-->
</div>
@endsection