
@extends ('index')
@section('contenido')
 <div class="row">
 	<div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12">
 		<h3>Listado de vendedores</h3>
 		{!! Form::open(array('url'=>'vendedores','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
 		<div class="form-group">
 			<div class="input-group">
 				<input type="text" name="searchText" class="form-control" placeholder="buscar por nombre o documento" value="{{$searchText}}">
 				<span class="input-group-btn">
 					<button class="btn btn-success" type="submit">buscar</button>
 				</span>
 			</div>
 		</div>
 		{{Form::close()}}
 	</div>	
 	<div class="row">
 		<div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12">
 			<div class="table-responsive">
 				<table class="table table-striped table-bordered table-condensed table-hover">
 					<thead>
 						<th>Nombre</th>
 						<th>Documento</th>
 						<th>Pedidos Ingresados</th>
 						<th>Ver Pedidos</th>
 					</thead>
 					@foreach($vendedores as $v)
 					<tr>
 						<td>{{$v->nombre}}</td>
 						<td>{{$v->documento}}</td>
 						<td>{{$v->pedidos}}</td>
 						<td><a href="{{URL::action('ReporteController@verV',$v->idpersona)}}"><button class="btn btn-info">ver</button></a></td>
 					</tr>

 					@endforeach
 				</table>
 			</div>
 			{{$vendedores->render()}}
 		</div>
 	</div>
 </div>
@endsection