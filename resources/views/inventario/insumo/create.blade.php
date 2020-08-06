@extends ('index')
@section('contenido')
<div class="row">
	<div class="col col-lg-12 col-md-12  col-xs-12">
		<h3>Añadir Insumo</h3> 
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

    <div >
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
    <div class="">
 
     <button type="submit" class="btn btn-primary">guardar</button>
       <a href="{{route('insumo.index')}}" class="btn btn-danger">cancelar</a>
     {!! Form::close() !!}
    </div>
   </div>
  </div>
 </form>
</div>





@endsection