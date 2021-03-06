{!! Html::script('js/demandaProductos/create.js') !!}

{!! Form::open(['route' => 'demanda-producto.store', 'method' => 'POST']) !!}

	{!! Form::hidden('tipo_creador', session('perfilTipo')) !!}
	{!! Form::hidden('creador_id', session('perfilId')) !!}

	<div class="form-group">
		{!! Form::label('titulo', 'Título de la Demanda') !!}
		{!! Form::text('titulo', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el título']) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label('opcion', '¿Qué tipo de producto busca?') !!}
		{!! Form::select('tipo_producto', ['P' => 'Producto Específico', 'B' => 'Bebida por Región'], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción..', 'id' => 'opcion', 'onchange' => 'cargarOpcion();']) !!}
	</div>

	<div class="form-group" id="productos" style="display: none;">
		{!! Form::label('productos', 'Producto') !!}
		{!! Form::select('producto_id', $productos, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un producto']) !!}
	</div>

	<div id="bebidas" style="display: none;">
		<div class="form-group">
			{!! Form::label('bebidas', 'Bebida') !!}
			{!! Form::select('bebida_id', $bebidas, null, ['class' => 'form-control', 'placeholder' => 'Seleccione una bebida']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('paises', 'País') !!}
			{!! Form::select('pais_id', $paises, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un país', 'id' => 'pais_id', 'onchange' => 'cargarProvincias();']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('provincias', 'Provincia') !!}
			<select class="form-control" name="provincia_region_id" id="provincias">
				<option value="">Seleccione una provincia..</option>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		{!! Form::label('descripcion', 'Descripción de la demanda') !!}
		{!! Form::textarea('descripcion', null, ['class' => 'form-control', 'placeholder' => 'Ingrese una breve descripción']) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label('cantidad_minima', 'Ingrese la cantidad mínima deseada') !!}
		{!! Form::number('cantidad_minima', '0', ['class' => ' form-control'] ) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label('cantidad_maxima', 'Ingrese la cantidad máxima deseada') !!}
		{!! Form::number('cantidad_maxima', '0', ['class' => ' form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::submit('Registrar', ['class' => 'btn btn-primary']) !!}
	</div>

{!! Form::close() !!}