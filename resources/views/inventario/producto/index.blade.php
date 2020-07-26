@extends ('index')
@section('contenido')
 <div class="row">
 	<div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12">
 		<h3>Listado de Productos <a href="producto/create"><button class="btn btn-success">Nuevo</button></a></h3>
 		@include('inventario.producto.search')
 	</div>	
 	<div class="row">
 		<div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12">
 			<div class="table-responsive">
 				<table class="table table-striped table-bordered table-condensed table-hover">
 					<thead>
 						<th>Id</th>
 						<th>Nombre</th>
 						<th>valor</th>
 						<th>Categoria</th>
 						<th>Tiempo de elaboracion</th>
 						<th>Costo de Produccion</th>
 						<th>Imagen</th>
 						<th>Opciones</th>
 					</thead>
 					@foreach($productos as $p)
 					<tr>
 						<td>{{$p->idproducto}}</td>
 						<td>{{$p->nombre}}</td>
 						<td>${{$p->valor}}</td>
 						<td>{{$p->categoria}}</td>
 						<td>{{$p->tiempoelaboracion}} minutos</td>
 						<td> ${{$p->costoProduccion}}</td>
 						<td>
 							@if($p->imagen!='')
 							  <img src="{{asset('imagenes/productos/'.$p->imagen)}}" alt="{{ $p->nombre}}" height="100px" width="100px" class="img-thumbnail">
 							  @else
 							  Sin Imagen
 							  @endif
 						</td>
 						<td>
 							<a href="{{URL::action('ProductoController@edit',$p->idproducto)}}"><button class="btn btn-info">editar</button></a>
 							<a href="" data-target="#modal-delete-{{$p->idproducto}}" data-toggle="modal"><button class="btn btn-danger">eliminar</button></a>
 							@include('inventario.producto.modal')
 						</td>
 					</tr>

 					@endforeach
 				</table>
 			</div>
 			{{$productos->render()}}
 		</div>
 	</div>
 </div>
@endsection