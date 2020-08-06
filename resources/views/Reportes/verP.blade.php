@extends('index')
@section('contenido')
<div class="row ">	
	<div class="col col-md-12 col-xs-12">
		<h3> Pedidos De {{$panadero->nombre}}, doc:{{$panadero->documento}}</h3>
	</div>

</div>
	{!! Form::open(array('url'=>'verPfechas','id'=>'buscarfechas','method'=>'POST','autocomplete'=>'off')) !!}
	{{Form::token()}}
	<input type="hidden" name="idpanadero" value="{{$panadero->idPersona}}">
<div class="row">
	<div class="col col-md-3 col-xs-12">
		<div class="form-check">
  <input class="form-check-input" type="radio" name="fechasselect"  value="ingreso" checked>
  <label class="form-check-label" >
    Por fecha de ingreso
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="fechasselect"  value="entrega">
  <label class="form-check-label" >
   Por fecha de entrega
  </label>
</div>
	</div>
	<div class="col-md-3 col-xs-12">
								<div class="form-group">
									<label for="fechadesde">Desde:</label>
									<div class="input-group date" data-provide="datepicker" data-date-format="mm/dd/yyyy">
										<input class="date form-control" readonly="true"  type="text" id="datepickerDESDE" name="fechadesde">
										<div class="input-group-addon">
											<i class="fa fa-circle-o"></i>
										</div>
									</div>
								</div>
	</div>
	<div class="col-md-3 col-xs-12">
								<div class="form-group">
									<label for="fechahasta">Hasta:</label>
									<div class="input-group date" data-provide="datepicker" data-date-format="mm/dd/yyyy">
										<input class="date form-control" readonly="true"  type="text" id="datepickerHASTA" name="fechahasta">
										<div class="input-group-addon">
											<i class="fa fa-circle-o"></i>
										</div>
									</div>
								</div>
	</div>
	<div class="col-md-3 col-xs-12">
		<button class="btn btn-success" onclick="validar()" type="button">buscar</button>
	</div>
		{!! Form::close() !!}
</div>
<div class="row">
 		<div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12">
 			<div class="table-responsive">
 				<table class="table table-striped table-bordered table-condensed table-hover">
 					<thead>
 						<th>Id</th>
 						<th>cliente</th>
 						<th>Vendedor</th>
 						<th>Fecha de ingreso</th>
 						<th>Fecha de Entrega</th>
 						<th>Estado</th>
 						<th>Total</th>
 						<th>Opciones</th>
 					</thead>
 					@foreach($pedidos as $p)
 					<tr>
 						<td>{{$p->idpedido}}</td>
 						<td>@foreach($clientes as $c)
 							@if($p->idcliente == $c->idPersona)
 							{{$c->nombre}}
 							@endif
 							@endforeach
 						</td>
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
 	@push('scripts')
  <script>
  $( function() {
    $( "#datepickerDESDE" ).datepicker({
    	firstDay: 1,
		maxDate: "+2M",
    	changeMonth: true,
    	onClose: function (selectedDate) {
    		$("#datepickerHASTA").datepicker("option", "minDate", selectedDate);
    	}
    });
    $( "#datepickerHASTA" ).datepicker({
    	firstDay: 1,
    	minDate: "-0D",
    	changeMonth: true,
    	onClose: function (selectedDate) {
    		$("#datepickerDESDE").datepicker("option", "maxDate", selectedDate);
    	}
    });
 

  } );

	function validar(){
  		console.log("validando")
  		if($("#datepickerDESDE").val()!=""){
  			if($("#datepickerHASTA").val()!=""){
  				$("#buscarfechas").submit();
  			}else{
  					Swal.fire(
		  					'Error',
		  					'indique una fecha limite para la busqueda',
		  					'error'
						);
  			}
    		
  		}else{
  				Swal.fire(
		  					'Error',
		  					'indique una fecha de inicio para la busqueda',
		  					'error'
						);
  		}
    	}

  </script>
@endpush
@endsection