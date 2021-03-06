@extends('plantillas.productor.mainProductor')
@section('title', 'Listado de Importadores')

@section('items')
	<span><strong><h3>Mis Importadores</h3></strong></span>
@endsection

@section('content-left')
	<div class="row">
		@foreach($importadores as $importador)
			<?php 
				$pais = DB::table('pais')
							->select('pais')
							->where('id', $importador->pais_id)
							->get()->first();
			 ?>
			<div class="col-md-6 col-xs-12">
          		<!-- Widget: user widget style 1 -->
          		<div class="box box-widget widget-user-2">
           			<!-- Add the bg color to the header using any of the bg-* classes -->
            		<div class="widget-user-header bg-green">
              			<div class="widget-user-image">
                			<img class="img-circle" src="{{ asset('imagenes/importadores/')}}/{{ $importador->logo }}" alt="User Avatar">
              			</div>
              			<!-- /.widget-user-image -->
              			<h3 class="widget-user-username">{{ $importador->nombre }}</h3>
              			<h5 class="widget-user-desc"> {{ $pais->pais }} </i></h5>
           			</div>
            		
            		<div class="box-footer no-padding">
              			<ul class="nav nav-stacked">
              				<li class="active"><a><stron>Correo: </stron> {{ $importador->email }} </a></li>
              				<li class="active"><a><stron>Teléfono: </stron> {{ $importador->telefono }} </a></li>
              				<li class="active"><a><stron>Créditos Disponibles: </stron> {{ $importador->saldo }} </a></li>
			            </ul>
            		</div>
         		</div>
          		<!-- /.widget-user -->
       		</div>
		@endforeach

	</div>
	<div>
		{{ $importadores->render() }}
	</div>

@endsection