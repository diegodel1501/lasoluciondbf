
@extends ('index')
@section('contenido')
 <div class="row">
 	<div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12">
 		<h3>Listado de vendedores</h3>
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
 						<th>Pedidos Ingresados</th>
 					</thead>
 					@foreach($vendedores as $v)
 					<tr>
 						<td>{{$v->nombre}}</td>
 						<td>{{$v->documento}}</td>
 						<td>{{$v->telefono}}</td>
 						<td>{{$v->email}}</td>
 						<td>{{$v->direccion}}</td>
 						<td>{{$v->pedidos}}</td>
 					</tr>

 					@endforeach
 				</table>
 			</div>
 			{{$vendedores->render()}}
 		</div>
 	</div>
 </div>
@endsection