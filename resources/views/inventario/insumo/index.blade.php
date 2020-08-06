@extends ('index')
@section('contenido')
 <div class="row">
 	<div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12">
 		<h3>Listado de Insumos <a href="insumo/create"><button class="btn btn-success">Nuevo</button></a></h3>
 		@include('inventario.insumo.search')
 	</div>	
 	<div class="row">
 		<div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12">
 			<div class="table-responsive">
 				<table class="table table-striped table-bordered table-condensed table-hover">
 					<thead>
 						<th>Id</th>
 						<th>Nombre</th>
 						<th>Descripcion</th>
 						<th>Imagen</th>
 						<th>total comprado</th>
 						<th>Opciones</th>
 					</thead>
 					@foreach($insumos as $i)
 					<tr>
 						<td>{{$i->idinsumo}}</td>
 						<td>{{$i->nombre}}</td>
 						<td>{{$i->descripcion}}</td>
 						<td>@if($i->imagen!='')
 							  <img src="{{asset('imagenes/insumos/'.$i->imagen)}}" alt="{{ $i->nombre}}" height="100px" width="100px" class="img-thumbnail">
 							  @else
 							  	Sin Imagen
 							  @endif
 						</td>
 						<td>{{$i->stock}}</td>
 						<td>
 							<a href="{{URL::action('InsumoController@edit',$i->idinsumo)}}"><button class="btn btn-info">editar</button></a>
 							<a href="" data-target="#modal-delete-{{$i->idinsumo}}" data-toggle="modal"><button class="btn btn-danger">eliminar</button></a>
 							@include('inventario.insumo.modal')
 						</td>
 					</tr>

 					@endforeach
 				</table>
 			</div>
 			{{$insumos->render()}}
 		</div>
 	</div>
 </div>
@endsection