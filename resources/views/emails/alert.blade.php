<!DOCTYPE html>
<html lang="es-ES">
<head>
	<meta charset="utf-8">
	<title>Alerta de pedido</title>
</head>
<body>
	<h2>Esta es una alerta automatica</h2>
	<div>
		la fecha del pedido {{$id}} , esta proximo a terminar: {{$fecha}} por favor prepare lo necesario:
	</div>
	<div>
		@foreach($insumos as $i)
		<p>
			@foreach($productos as $p)
			@if($i->idproducto==$p->idproducto)
				{{$p->nombre}}: {{$i->cantidad}} 
				@break
			@endif
			@endforeach
		</p>
		@endforeach
	</div>
</body>
</html>