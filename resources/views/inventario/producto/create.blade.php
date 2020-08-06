@extends ('index')
@section('contenido')

						<div class="row">
							<div class="col col-lg-6 col-md-6  col-xs-6">
								<h3>Nuevo Producto</h3>
								@if(count($errors)>0)
								<div class="alert alert-danger">
									<ul>
										@foreach ($errors->all() as $error)
										@if($error!='El campo idcategoria debe ser un numero.')
										<li>{{$error}}</li>
										@else
										<li>Seleccione una categoria</li>
										@endif
										@endforeach
									</ul>
								</div>
								@endif
							</div>
						</div>
						{!! Form::open(array('url'=>'producto','id'=>'formproductocreate','method'=>'POST','autocomplete'=>'off','files'=>'true')) !!}
						{{Form::token()}}
						<div class="row">
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label for="nombre">Nombre</label>
									<input type="text" id="nombre" name="nombre" class="form-control" required value="{{old('nombre')}}">
								</div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label for="tiempoelaboracion">Tiempo de elaboracion (min)</label>
									<input type="number" id="tiempoelaboracion" name="tiempoelaboracion" class="form-control" required value="{{old('tiempoelaboracion')}}" placeholder="tiempo en minutos">
								</div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label for="idcategoria">Categoria</label>
									<select id="idcategoria" name="idcategoria" class="form-control selectpicker" data-live-search="true">
										<option value="seleccione" selected="selected"> seleccione </option>
										@foreach ($categorias as $cat)
										<option value="{{$cat->idcategoria}}"> {{$cat->nombre}} </option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label for="valor">Valor</label>
									<input type="number" id="valor" name="valor" class="form-control" required value="{{old('valor')}}">
								</div>
							</div>

							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label for="descripcion">Descripcion</label>
									<textarea type="text" name="descripcion" class="form-control" value="{{old('descripcion')}}" placeholder="descripcion..."></textarea>
								</div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label for="imagen">Imagen</label>
									<input type="file" name="imagen" class="form-control" >
								</div>
							</div>
						</div>
					<div class="col-md-12">
						<!--Contenido-->
						<div class="row">
							<div class="col-md-12 col-xs-12">
								<div id="formulario">
									<h3>Insumo(s): <button class="btn btn-primary " id="añadirInsumo" onclick="agregar(); "type="button">añadir</button></h3>
									
									<div class="inputclon">
										<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label >insumo</label>
									<select name="pidinsumo" id="pidinsumo" class="form-control selectpicker" data-live-search="true">
										<option value="seleccione" selected="selected"> seleccione </option>
										@foreach ($insumos as $in)
										<option value="{{$in->idinsumo}}-{{$in->costototal}}-{{$in->totalcomprado}}"> {{$in->nombre}} </option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label >Cantidad (En kg, Lts o unidad(es)</label>
									<input type="number" step="any" name="pcantidad" id="pcantidad" class="form-control" value="">
									<input type="hidden" id="costototalinput" name="costo" value="">
								</div>
							</div>
									</div>
								</div>
							</div>
						</div>
						<!--Fin Contenido-->
						<div class="row container">
							<table id="tableInsumo" class="table table-striped table-bordered table-condensed table-hover col-xs-12">
								<thead>
									<th>Opciones</th>
									<th>Insumo</th>
									<th>Costo</th>
									<th>Cantidad</th>
									<th>Sub total</th>
								</thead>
								<tbody>
									
									
								</tbody>
								<tfoot>
									<th>TOTAL: <span id="totalproducto">$0</span></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
								</tfoot>
							</table>
						</div>
					</div>
<div class="row">	
	<div class="col-md-6 col-xs-12">		
		<div class="form-group">
			<a class="btn btn-primary" class="form-control" id="btnGuardarProducto" onclick="enviar();" type="button">guardar</a>
			<a href="{{route('producto.index')}}" class="btn btn-danger">cancelar</a>
		</div>

	</div>
	{!! Form::close() !!}

	<!--Fin Contenido-->
</div>
@push('scripts')
<script >
	var cont=0;
	var subtotal=[];
	var total=0;
	$( document ).ready(function() {
    console.log( "ready!" );
    evaluar();
});
	function enviar(){
		if(verificarcampos()){
		$("#costototalinput").val(total);
		$("#formproductocreate").submit();	
		}
	}
	function verificarcampos(){
		let nombre=$("#nombre").val();
		let tiempo=$("#tiempoelaboracion").val();
		let valor=$("#valor").val();
		let idcat=$("#idcategoria option:selected").val();	
		if(nombre!=""){
			if(tiempo!=""){
				if(valor!=""){
					if(idcat!="" && !isNaN(idcat)){
						return true;
					}else{
						Swal.fire(
		  					'Error',
		  					'indique una categoria para el producto',
		  					'error'
						);
					}
				}else{
						Swal.fire(
		  					'Error',
		  					'indique una valor para el producto',
		  					'error'
						);
				}
			}else{
					Swal.fire(
		  					'Error',
		  					'indique un tiempo de elaboracion para el producto',
		  					'error'
						);
			}
		}else{
				Swal.fire(
		  					'Error',
		  					'indique un nombre para el producto',
		  					'error'
						);
		}
		return false;
	}
	function limpiar(){
		console.log("limpiar");
		$("#pidinsumo").val('default').selectpicker("refresh");
		$("#pcantidad").val("");
	}
	function evaluar(){
		if(total>0){
			$("#btnGuardarProducto").show();
		}else{
			$("#btnGuardarProducto").hide();
		}
		
	}
	function eliminar(index){
		console.log("eliminando");
		total-=subtotal[index];
		$("#totalproducto").html("$"+total);
		$("#fila"+index).remove("#fila"+index);
		evaluar();
	}
	function eliminar(index){
		console.log("eliminando");
		total-=subtotal[index];
		$("#totalproducto").html("$"+total);
		$("#fila"+index).remove("#fila"+index);
		evaluar();
	}
	function agregar(){
		
		//obteniendo costo cantidad comprada a ese precio y id del insumo
		var insumoNombre=$("#pidinsumo option:selected").text();
		var insumo=$("#pidinsumo option:selected").val();
		if(insumo!="" && insumo!=null && insumo!="seleccione" ){
		let arrIdCostoCantidad=insumo.split("-");
		var id=parseInt(arrIdCostoCantidad[0]);
		var costo=parseInt(arrIdCostoCantidad[1]);
		var cantidad=parseInt(arrIdCostoCantidad[2]);
		}else{
			insumoNombre="";
		}
	
		// fin del spplit
		// calculando costo por cantidad agregada
		let cant=$("#pcantidad").val();// cantidad a usar del insumo en el producto
		
		// fin calculo
		let datos="";//variable para los td
		if(id!="" && !isNaN(id) && insumoNombre!="" && cant!="" && parseFloat(cant)>0){
			let precioPorUnidad=costo/cantidad;
			let costoUsado=parseFloat(precioPorUnidad)*parseFloat(cant);
			subtotal[cont]=costoUsado;
			total+=subtotal[cont];
			//solo para ordenarme parto las filas
				datos+='<td><button class="btn btn-danger " onclick="eliminar('+cont+'); "type="button">eliminar</button></td>';
			datos+='<td><input type="hidden" name="idinsumo[]" value="'+id+'">'+insumoNombre+'</td>';
			datos+='<td>'+precioPorUnidad+'</td>';
			datos+='<td><input type="hidden" name="cantidad[]"  value="'+cant+'">'+cant+' </td>';
			datos+='<td>'+subtotal[cont]+'</td>';
			let fila='<tr id="fila'+cont+'">'+datos+'</tr>';
		
			//agregar la fila
			$("#tableInsumo tbody").append(fila);

			$("#totalproducto").html("$"+total);
			limpiar();
			evaluar();
			cont++;
		}else{
			Swal.fire(
		  					'Error',
		  					'rellene los campos por favor',
		  					'error'
						);

		}

	}

</script>
@endpush
@endsection



