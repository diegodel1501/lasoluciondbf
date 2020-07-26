{!! Form::open(array('url'=>'empleado','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="form-group">
	<div class="input-group">
		<input type="text" name="searchText" class="form-control" placeholder="buscar.." value="{{$searchText}}">
		<span class="input-group-btn">
			<button class="btn btn-success" type="submit">buscar</button>
		</span>
	</div>
</div>
{{Form::close()}}