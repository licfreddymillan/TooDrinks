@extends('plantillas.main')
@section('title', 'Demanda de Producto')

@section('items')
@endsection

@section('content-left')
   <?php 
      if ($demandaProducto->tipo_creador == 'I'){
         $creador = DB::table('importador')
                     ->select('nombre', 'persona_contacto', 'telefono', 'email')
                     ->where('id', '=', $demandaProducto->creador_id)
                     ->first();
      }elseif ($demandaProducto->tipo_creador == 'D'){
         $creador = DB::table('distribuidor')
                     ->select('nombre', 'persona_contacto', 'telefono', 'email')
                     ->where('id', '=', $demandaProducto->creador_id)
                     ->first();
      }else{
         $creador = DB::table('horeca')
                     ->select('nombre', 'persona_contacto', 'telefono', 'email')
                     ->where('id', '=', $demandaProducto->creador_id)
                     ->first();
      }
    ?>
    @section('title-header')
        <h3><b>{{ $demandaProducto->titulo }}</b></h3>
    @endsection

    @if (Session::has('msj'))
      <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
      </div>
    @endif

    <div class="row">
       <div class="col-md-4"></div>
        <div class="col-sm-6 col-md-4">
            @if ($demandaProducto->producto_id != '0')
               <a href="" class="thumbnail"><img src="{{ asset('imagenes/productos/thumbnails') }}/{{ $demandaProducto->producto->imagen }}"></a>
            @else
               <a href="" class="thumbnail"><img src="{{ asset('imagenes/productos/bebida.jpg') }}"></a>
            @endif
        </div>
        <div class="col-md-4"></div>
    </div>

    <div class="row">
       <div class="col-md-1"></div>
       <div class="col-md-10 col-xs-12">
          
          <div class="panel panel-default panel-success">
            <div class="panel-heading"><h4><b> Bebida: {{ $demandaProducto->bebida->nombre }}</b></h4></div>
             
            <ul class="list-group">
               <li class="list-group-item"><b>Descripción:</b> {{ $demandaProducto->descripcion }}</li>
               <li class="list-group-item"><b>Cantidad Mínima Requerida:</b> {{ $demandaProducto->cantidad_minima }} unidades.</li>
               <li class="list-group-item"><b>Cantidad Máxima Requerida:</b> {{ $demandaProducto->cantidad_maxima }} unidades.</li>
               <li class="list-group-item">@if ($demandaProducto->tipo_creador == 'I') 
                  <b>Importador:</b> @elseif ($demandaProducto->tipo_creador == 'D') <b>Distribuidor:</b> @else <b>Horeca:</b> @endif {{ $creador->nombre }}</li>
                <li class="list-group-item"><b>Persona de Contacto:</b> {{ $creador->persona_contacto }}</li>
                <li class="list-group-item"><b>Teléfono:</b> {{ $creador->telefono }}</li>
                <li class="list-group-item"><b>Correo Electrónico:</b> {{ $creador->email }}</li>
               
             </ul>
          </div>
       </div>
       <div class="col-md-1"></div>
    </div>

    
@endsection