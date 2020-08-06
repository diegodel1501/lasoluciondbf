
@extends ('index')
@section('contenido')
 <div class="row">
 	<div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12">
 		<h3>Listado de Panaderos</h3>
 			{!! Form::open(array('url'=>'panaderos','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
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
 						<th>Participacion en pedidos</th>
 						<th>productos encargados</th>
 						<th>Ver pedidos</th>
 					</thead>
 					@foreach($panaderos as $p)
 					<tr>
 						<td>{{$p->nombre}}</td>
 						<td>{{$p->documento}}</td>
 						<td>{{$p->pedidos}}</td>
 						<td>{{$p->productos}}</td>
 						<td><a href="{{URL::action('ReporteController@verP',$p->idPersona)}}"><button class="btn btn-info">ver</button></a></td>
 					</tr>

 					@endforeach
 				</table>
 			</div>
 			{{$panaderos->render()}}
 		</div>
 	</div>
 </div>
@endsection