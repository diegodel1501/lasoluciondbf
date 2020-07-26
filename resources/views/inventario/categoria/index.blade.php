@extends ('index')
@section('contenido')
 <div class="row">
 	<div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12">
 		<h3>Listado de categorias <a href="categoria/create"><button class="btn btn-success">Nuevo</button></a></h3>
 		@include('inventario.categoria.search')
 	</div>	
 	<div class="row">
 		<div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12">
 			<div class="table-responsive">
 				<table class="table table-striped table-bordered table-condensed table-hover">
 					<thead>
 						<th>Id</th>
 						<th>Nombre</th>
 						<th>Descripcion</th>
 						<th>Opciones</th>
 					</thead>
 					@foreach($categorias as $cat)
 					<tr>
 						<td>{{$cat->idcategoria}}</td>
 						<td>{{$cat->nombre}}</td>
 						<td>{{$cat->descripcion}}</td>
 						<td>
 							<a href="{{URL::action('CategoriaController@edit',$cat->idcategoria)}}"><button class="btn btn-info">editar</button></a>
 							<a href="" data-target="#modal-delete-{{$cat->idcategoria}}" data-toggle="modal"><button class="btn btn-danger">eliminar</button></a>
 							@include('inventario.categoria.modal')
 						</td>
 					</tr>

 					@endforeach
 				</table>
 			</div>
 			{{$categorias->render()}}
 		</div>
 	</div>
 </div>
@endsection