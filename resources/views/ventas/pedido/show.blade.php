@extends ('index')
@section('contenido')
<div class="row">
	<div class="col-md-6 col-xs-12">
		<div class="form-group">
			<label for="">Vendedor: {{$vendedor->nombre, $vendedor->documento}}</label>
		</div>
	</div>
	<div class="col-md-6 col-xs-12">
		<div class="form-group">
			<label for="">Cliente: {{$cliente->nombre, $cliente->documento}}</label>
		</div>
	</div>
	<div class="col-md-6 col-xs-12">
		<div class="form-group">
			<label for="fechaentrega">Fecha De Entrega: {{$pedido->fechaentrega}}</label>
		</div>
	</div>
</div>
<div >
		<h3>Detalles:</h3>
		@foreach ($productos as $p)
		<div class="row">
			<div class="col-md-6 col-xs-12">
				<div class="form-group">
					<label for="">Producto: {{$p->nombre}}</label>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">

		<div class="form-group">
			<label for="">Panadero: 
				@foreach($panaderos as $pa)
				@if($p->idpanaderoA == $pa->idpanaderoB)
				{{$pa->nombre}}
				@endif()
				@endforeach
				
			</label>
		</div>
	</div>
			<div class="col-md-3 col-xs-12">

				<div class="form-group">
					<label for="">valor: {{$p->valor}}</label>
				</div>
			</div>
			<div class="col-md-3 col-xs-12">
				<div class="form-group">
					<label for="">Cantidad: {{$p->cantidad}}</label>
				</div>
			</div>
			<div class="col-md-3 col-xs-12">
				<div class="form-group">
					<label for="">tiempo Estimado: {{$p->cantidad*$p->tiempoelaboracion}} min</label>
				</div>
			</div>
			<div class="col-md-3 col-xs-12">
				<div class="form-group">
					<label >Subtotal: {{$p->valor*$p->cantidad}}</label>
				</div>
			</div>
		</div>
		<div class="col-md-12 col-xs-12">
		-------------------------------------------------------------------	
		</div>

		@endforeach
		
	</div>
	<div >
		<strong><P>Total: {{$pedido->total}}</P></strong>
	</div>

@endsection



