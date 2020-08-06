@extends ('index')
@section('contenido')
 <div class="row">
 	<div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12">
 		<h3>Listado de Clientes <a href="cliente/create"><button class="btn btn-success">Nuevo</button></a></h3>
 		@include('ventas.cliente.search')
 	</div>	
 	<div class="row">
 		<div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12">
 			<div class="table-responsive">
 				<table class="table table-striped table-bordered table-condensed table-hover">
 					<thead>
 						<th>Id</th>
 						<th>Nombre</th>
 						<th>documento</th>
 						<th>telefono</th>
 						<th>email</th>
 						<th>direccion</th>
 						<th>Opciones</th>
 					</thead>
 					@foreach($personas as $p)
 					<tr>
 						<td>{{$p->id}}</td>
 						<td>{{$p->nombre}}</td>
 						<td>{{$p->documento}}</td>
 						<td>{{$p->telefono}}</td>
 						<td>{{$p->email}}</td>
 						<td>{{$p->direccion}}</td>
 						<td>
 							<a href="{{URL::action('ClienteController@edit',$p->id)}}"><button class="btn btn-info">editar</button></a>
 							<a href="" data-target="#modal-delete-{{$p->id}}" data-toggle="modal"><button class="btn btn-danger">eliminar</button></a>
 							@include('ventas.cliente.modal')
 						</td>
 					</tr>

 					@endforeach
 				</table>
 			</div>
 			{{$personas->render()}}
 		</div>
 	</div>
 </div>
@endsection