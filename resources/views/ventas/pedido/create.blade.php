@extends ('index')
@section('contenido')

						<!--Contenido-->
						<div class="row">
							<div class="col col-lg-6 col-md-6  col-xs-6">
								<h3>Nuevo Pedido</h3>
								@if(count($errors)>0)
								<div class="alert alert-danger">
									<ul>

										@foreach ($errors->all() as $error)
										<li>{{$error}}</li>
										@endforeach
									</ul>
								</div>
								@endif
							</div>
						</div>
						{!! Form::open(array('url'=>'pedido','method'=>'POST','autocomplete'=>'off')) !!}
						{{Form::token()}}
						<div class="row">
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label for="idvendedor">Vendedor</label>
									<select name="idvendedor" class="form-control selectpicker " data-live-search="true">
										<option value="" > seleccione </option>
										@foreach ($vendedores as $v)
										<option value="{{$v->idPersona}}"> {{$v->nombre}} </option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label for="idcliente">Cliente</label>
									<select name="idcliente" class="form-control selectpicker" data-live-search="true">
										<option value=""> seleccione </option>
										@foreach ($clientes as $c)
										<option value="{{$c->idPersona}}"> {{$c->nombre}} </option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label for="fechaentrega">Fecha De Entrega</label>
									<div class="input-group date" data-provide="datepicker" data-date-format="mm/dd/yyyy">
										<input class="date form-control"  type="text" id="datepicker" name="fechaentrega">

										<div class="input-group-addon">
											<i class="fa fa-circle-o"></i>
										</div>
									</div>
								</div>
							</div>
							<div class="container">
								<h3>Producto(s): <button class="btn btn-primary " id="añadirInsumo" onclick="agregar(); "type="button">añadir</button></h3>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label for="idpanadero">Panadero</label>
									<select name="idpanadero" id="idpanadero" class="form-control selectpicker" data-live-search="true">
										<option value=""> seleccione </option>
										@foreach ($panaderos as $p)
										<option value="{{$p->idPersona}}"> {{$p->nombre}} </option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label for="pproducto">Producto</label>
									<select name="pproducto" id="pproducto" class="form-control selectpicker" data-live-search="true">
										<option value="" > seleccione </option>
										@foreach ($productos as $p)
										<option value="{{$p->idproducto}}-{{$p->valor}}"> {{$p->nombre}} </option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col col-md-4 col-xs-12 ">
								<div class="form-group">
								<label for="pcantidad">Cantidad</label>
								<input type="number" step="any" name="pcantidad" id="pcantidad" class="form-control">	
								</div>
							</div>

						</div>
						<div class="row container">
							<table id="tableDetalle" class="table table-striped table-bordered table-condensed table-hover col-xs-12">
								<thead>
									<th>Opciones</th>
									<th>Panadero</th>
									<th>producto</th>
									<th>valor</th>
									<th>Cantidad</th>
									<th>Sub total</th>
								</thead>
								<tbody>
									
								</tbody>
								<tfoot>
									<th>TOTAL: <span id="totalpedido">$0</span></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
								</tfoot>
							</table>
						</div>
						<div class="row">	
	<div class="col-md-6 col-xs-12">		
		<div class="form-group">
			<button class="btn btn-primary" id="btnGuardarPedido" class="form-control" type="submit">guardar</button>
			<a href="{{route('pedido.index')}}" class="btn btn-danger">cancelar</a>
		</div>
	</div>
					</div>

	{!! Form::close() !!}

	<!--Fin Contenido-->
</div>
@push('scripts')
  <script>
  $( function() {
    $( "#datepicker" ).datepicker();

    evaluar();
  } );


	var cont=0;
	var subtotal=[];
	var total=0;
function limpiar(){
		console.log("limpiar");
		$("#pproducto").val('default').selectpicker("refresh");
		$("#idpanadero").val('default').selectpicker("refresh");
		$("#pcantidad").val("");
	}
	function evaluar(){
		if(total>0){
			$("#btnGuardarPedido").show();
		}else{
			$("#btnGuardarPedido").hide();
		}
		
	}
	function eliminar(index){
		console.log("eliminando");
		total-=subtotal[index];
		$("#totalpedido").html("$"+total);
		$("#fila"+index).remove("#fila"+index);
		evaluar();
	}
	function agregar(){
		
		//obteniendo costo cantidad comprada a ese precio y id del insumo
		let productoNombre=$("#pproducto option:selected").text();
		let producto=$("#pproducto option:selected").val();
		let panaderoNombre=$("#idpanadero option:selected").text();
		let panaderoid=$("#idpanadero option:selected").val();
		let arrIdCosto=producto.split("-");
		console.log(arrIdCosto);
		let id=parseInt(arrIdCosto[0]);
		let valor=parseInt(arrIdCosto[1]);
		// fin del spplit
		// calculando costo por cantidad agregada
		let cant=$("#pcantidad").val();// cantidad  producto
		let costoUsado=valor*cant;
		// fin calculo
		let datos="";//variable para los td
		if(id!="" && !isNaN(id) && productoNombre!="" && cant!="" && parseFloat(cant)>0){
			subtotal[cont]=costoUsado;
			total+=subtotal[cont];
			//solo para ordenarme parto las filas
				datos+='<td><button class="btn btn-danger " onclick="eliminar('+cont+'); "type="button">eliminar</button></td>';
				datos+='<td><input type="hidden" name="idpanadero[]" value="'+panaderoid+'">'+panaderoNombre+'</td>';
			datos+='<td><input type="hidden" name="idproducto[]" value="'+id+'">'+productoNombre+'</td>';
			datos+='<td>'+valor+'</td>';
			datos+='<td><input type="hidden" name="cantidad[]"  value="'+cant+'">'+cant+' </td>';
			datos+='<td>'+subtotal[cont]+'</td>';
			let fila='<tr id="fila'+cont+'">'+datos+'</tr>';
		
			//agregar la fila
			$("#tableDetalle tbody").append(fila);

			$("#totalpedido").html("$"+total);
			limpiar();
			evaluar();
			cont++;
		}else{
			alert('error revise detalles id="'+id+'",insumo="'+productoNombre+'",cant="'+cant+'",parseFloat="'+parseFloat(cant)+'"');

		}

	}

  </script>
@endpush
@endsection



