
@extends ('index')
@section('contenido')
 <div class="row">
 	<div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12">
 		<h3>Listado de Clientes</h3>
 			{!! Form::open(array('url'=>'clientes','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
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
 						<th>Pedidos</th>
 						<th>Total</th>
 						<th>Ver Pedidos</th>
 					</thead>
 					@foreach($clientes as $c)
 					<tr>
 						<td>{{$c->nombre}}</td>
 						<td>{{$c->documento}}</td>
 						<td>{{$c->compras}}</td>
 						<td>{{$c->total}}</td>
 							<td><a href="{{URL::action('ReporteController@verC',$c->idPersona)}}"><button class="btn btn-info">ver</button></a></td>
 					</tr>

 					@endforeach
 				</table>
 			</div>
 			{{$clientes->render()}}
 		</div>
 	</div>
 </div>
@endsection