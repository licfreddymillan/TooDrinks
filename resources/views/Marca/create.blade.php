@extends('plantillas.main')
@section('title', 'Listar-marcas')
@section('content')
<div class="col-md-12"><center><h3> Agregar Marcas</h3></center></div>
<div class="col-md-4"></div>
<div class="col-md-4">
{!! Form::open(['route'=>'marca.store','method'=>'POST']) !!}
{!! Form::label ('nombre','Nombre') !!}
{!! Form::text ('nombre',null,['class'=>'form-control','placeholder'=>'Ej. Polar', 'required']) !!}

{!! Form::label ('nombre_seo','Nombre Seo') !!}
{!! Form::text ('nombre_seo',null,['class'=>'form-control','placeholder'=>'Ej. Polar Seo', 'required']) !!}

{!! Form::label ('descripcion','Descripcion') !!}
{!! Form::text ('descripcion',null,['class'=>'form-control','placeholder'=>'Ej. ', 'required']) !!}

{!! Form::label ('logo','Logo') !!}
{!! Form::file ('logo',null,['class'=>'form-control','required']) !!}

{!! Form::label ('reclamada','Reclamada') !!}
{!! Form::select ('reclamada',['Si'=>'Si','No'=>'No']) !!}
<div>
Pais
<select name="pais_id" id="">
	@foreach($paises as $pais)
	<option value="{{ $pais->id }}">{{ $pais->pais }}</option>
	@endforeach
</select>
</div>
<div>
Provincia
<select name="provincia_region_id" id="">
	@foreach($provincias as $provincia)
	<option value="{{ $provincia->id }}">{{ $provincia->provincia }}</option>
	@endforeach
</select>
</div>

Productor
<select name="productor_id" id="">
	@foreach($productores as $productor)
	<option value="{{ $productor->id }}">{{ $productor->nombre }}</option>
	@endforeach
</select>
</div>

{!! Form::hidden ('creador_id','3') !!}
{!! Form::hidden ('tipo_creador','Productor') !!}

{!! Form::submit ('Agregar',['class'=>'btn btn.primary']) !!}

{!! Form::close() !!}
</div>
<div class="col-md-4"></div>
@endsection