
@extends ('index')
@section('contenido')
 <div class="row">
 	<div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12">
 		<h3>Listado de Clientes</h3>
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
 						<th>Pedidos</th>
 						<th>Total</th>
 					</thead>
 					@foreach($clientes as $c)
 					<tr>
 						<td>{{$c->nombre}}</td>
 						<td>{{$c->documento}}</td>
 						<td>{{$c->telefono}}</td>
 						<td>{{$c->email}}</td>
 						<td>{{$c->direccion}}</td>
 						<td>{{$c->compras}}</td>
 						<td>{{$c->total}}</td>
 					</tr>

 					@endforeach
 				</table>
 			</div>
 			{{$clientes->render()}}
 		</div>
 	</div>
 </div>
@endsection