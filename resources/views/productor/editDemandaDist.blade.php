@extends('plantillas.productor.mainProductor')
@section('title', 'Demanda de Distribuidor')

@section('items')
	<span><strong><h3>Modificar Demanda de Distribución</h3></strong></span>
@endsection

@section('content-left')
	{!! Form::open(['route' => ['demanda-distribuidor.update', $demandaDistribuidor->id], 'method' => 'PUT']) !!}
		{!! Form::hidden('who', 'P') !!}
		{!! Form::hidden('tipo_creador', 'P') !!}
		{!! Form::hidden('creador_id', session('productorId')) !!}
		
		@include('demandaDistribucion.formularios.editForm')
	{!! Form::close() !!}

@endsection