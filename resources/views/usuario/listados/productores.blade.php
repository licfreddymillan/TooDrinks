@extends('plantillas.usuario.mainUsuario')
@section('title', 'Listado de Productores')

@section('content-left')

    @section('title-header')
    	@if (Session::has('msj'))
		    <div class="alert alert-success alert-dismissable">
		        <button type="button" class="close" data-dismiss="alert">&times;</button>
		        <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
		    </div>
		@endif
		<span><strong><h3>Mis Productores</h3></strong></span>
	@endsection

	<div class="row">
		@foreach($productores as $productor)
			@if ($productor->id != '0')
				<?php 
					$pais = DB::table('pais')
								->select('pais')
								->where('id', $productor->pais_id)
								->get()->first();
				 ?>
				<div class="col-md-6 col-xs-12">
	          		<!-- Widget: user widget style 1 -->
	          		<div class="box box-widget widget-user-2">
	           			<!-- Add the bg color to the header using any of the bg-* classes -->
	            		<div class="widget-user-header bg-blue">
	              			<div class="widget-user-image">
	                			<img class="img-rounded" src="{{ asset('imagenes/productores/thumbnails/')}}/{{ $productor->logo }}">
	              			</div>
	              			<!-- /.widget-user-image -->
	              			<h3 class="widget-user-username">{{ $productor->nombre }}</h3>
	              			<h5 class="widget-user-desc"> {{ $pais->pais }} </i></h5>
	           			</div>
	            		
	            		<div class="box-footer no-padding">
	              			<ul class="nav nav-stacked">
	              				<li class="active"><a><stron>Correo: </stron> {{ $productor->email }} </a></li>
	              				<li class="active"><a><stron>Teléfono: </stron> {{ $productor->telefono }} </a></li>
	              				<li class="active"><a><stron>Créditos Disponibles: </stron> {{ $productor->saldo }} </a></li>
				                <li class="active"><a href="{{ route('productor.show', $productor->id) }}" ><strong>Ingresar al perfil</strong> </a></li>
				            </ul>
	            		</div>
	         		</div>
	          		<!-- /.widget-user -->
	       		</div>
	       	@endif
		@endforeach

	</div>

	<div>
		<center>{!! $productores->render() !!}</center>
	</div>

@endsection