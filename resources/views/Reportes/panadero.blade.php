
@extends ('index')
@section('contenido')
 <div class="row">
 	<div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12">
 		<h3>Listado de Panaderos</h3>
 	</div>	
 	<div class="row">
 		<div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12">
 			<div class="table-responsive">
 				<table class="table table-striped table-bordered table-condensed table-hover">
 					<thead>
 						<th>Nombre</th>
 						<th>Documento</th>
 						<th>Telefono</th>
 						<th>Email</th>
 						<th>Direccion</th>
 						<th>Participacion en pedidos</th>
 						<th>productos encargados</th>
 					</thead>
 					@foreach($panaderos as $p)
 					<tr>
 						<td>{{$p->nombre}}</td>
 						<td>{{$p->documento}}</td>
 						<td>{{$p->telefono}}</td>
 						<td>{{$p->email}}</td>
 						<td>{{$p->direccion}}</td>
 						<td>{{$p->pedidos}}</td>
 						<td>{{$p->productos}}</td>
 					</tr>

 					@endforeach
 				</table>
 			</div>
 			{{$panaderos->render()}}
 		</div>
 	</div>
 </div>
@endsection