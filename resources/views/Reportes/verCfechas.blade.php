@extends('index')
@section('contenido')
<div class="row">
	<div class="col col-md-12 col-xs-12">
		<h3>{{$cliente->nombre}}, doc:{{$cliente->documento}}, desde: {{$fechadesde}}, hasta: {{$fechahasta}}</h3>
	</div>
</div>
<div class="row">
 		<div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12">
 			<div class="table-responsive">
 				<table class="table table-striped table-bordered table-condensed table-hover">
 					<thead>
 						<th>Id</th>
 						<th>vendedor</th>
 						<th>Fecha de ingreso</th>
 						<th>Fecha de Entrega</th>
 						<th>Estado</th>
 						<th>Total</th>
 						<th>Opciones</th>
 					</thead>
 					@foreach($pedidos as $p)
 					<tr>
 						<td>{{$p->idpedido}}</td>
 						<td>@foreach($vendedores as $v)
 							@if($p->idcliente == $v->idPersona)
 							{{$v->nombre}}
 							@endif
 							@endforeach
 						</td>
 						<td>{{$p->fechacreacion}}</td>
 						<td>{{$p->fechaentrega}}</td>
 						<td>{{$p->estado}}</td>
 						<td>{{$p->total}}</td>
 						<td>
 							<a href="{{URL::action('PedidoController@show',$p->idpedido)}}"><button class="btn btn-info">ver</button></a>
 							@if($p->estado!='terminado')
 							<a href="" data-target="#modal-delete-{{$p->idpedido}}" data-toggle="modal"><button class="btn btn-danger">terminar</button></a>
 							@include('ventas.pedido.modal')
 							@endif
 						</td>
 					</tr>

 					@endforeach
 				</table>
 			</div>
 			{{$pedidos->render()}}
 		</div>
 	</div>
@endsection