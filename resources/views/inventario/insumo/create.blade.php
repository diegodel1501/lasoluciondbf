@extends ('index')
@section('contenido')
<div class="row">
	<div class="col col-lg-12 col-md-12  col-xs-12">
		<h3>Añadir Insumo <a href="" data-target="#modal-nuevo-insumo" data-toggle="modal"><button class="btn btn-success">Añadir</button></a></h3> 
		@if(count($errors)>0)
		<div class="alert alert-danger">
			<ul>

				@foreach ($errors->all() as $error)
				@if($error!='El campo idinsumo debe ser un numero.')
				<li>{{$error}}</li>
				@else
				<li>El campo insumo no puede estar vacio</li>
				@endif
				@endforeach
			</ul>
		</div>
		@endif
	</div>
</div>
<div class="modal fade" id="modal-nuevo-insumo">
  <div class="modal-dialog">
   <div class="modal-content">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">
      <span aria-hidden>x</span>
     </button>
     <h4 class="modal-title">Añadir Insumo</h4>
    </div>
    <div class="modal-body">
     {!! Form::open(array('url'=>'insumo','method'=>'POST','autocomplete'=>'off','files'=>'true')) !!}
{{Form::token()}}
<div class="row ">
	<div class="col-md-12 col-xs-12">
		<div class="form-group">
			<label for="nombre">Nombre</label>
			<input type="text" name="nombre" class="form-control" required value="{{old('nombre')}}">
		</div>
	</div>
	<div class="col-md-12 col-xs-12">
		<div class="form-group">
			<label for="descripcion">Descripcion</label>
			<input type="text" name="descripcion" class="form-control" value="{{old('descripcion')}}">
		</div>
	</div>
	<div class="col-md-12 col-xs-12">
		<div class="form-group">
			<label for="imagen">Imagen</label>
			<input type="file" name="imagen" class="form-control" >
		</div>
	</div>	
</div>
    </div>
    <div class="modal-footer">
     <button type="button" class="btn btn-default" data-dismiss="modal">
      Cerrar
     </button>
     <button type="submit" class="btn btn-primary">guardar</button>
     {!! Form::close() !!}
    </div>
   </div>
  </div>
 </form>
</div>
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
			<button class="btn btn-primary" class="form-control" id="btnGuardarProducto"type="submit">guardar</button>
			<a href="{{route('producto.index')}}" class="btn btn-danger">cancelar</a>
		</div>

	</div>
	{!! Form::close() !!}

	<!--Fin Contenido-->
</div>




@endsection