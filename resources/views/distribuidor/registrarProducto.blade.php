@extends('plantillas.distribuidor.mainDistribuidor')
@section('title', 'Registrar Producto')

@section('items')

@endsection

@section('content-left')

	@section('title-header')
		<h3><b>Agregar Producto a la Marca {{ $marca }}</b></h3>
	@endsection
	
	{!! Form::open(['route' => 'producto.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
		{!! Form::hidden('who', 'D') !!}

		{!! Form::hidden('marca_id', $id)!!}
		{!! Form::hidden('marca_nombre', $marca) !!}
		{!! Form::hidden('tipo_creador', 'D') !!}
		{!! Form::hidden('creador_id', session('distribuidorId')) !!}
		{!! Form::hidden('publicado', '1') !!}
		{!! Form::hidden('confirmado', '0') !!}

			@include('producto.formularios.createForm')
		
		{!! Form::close() !!}

@endsection