<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oferta;
use App\Models\Producto;
use App\Models\Pais;
use App\Models\Provincia_Region; use App\Models\Destino_Oferta;
use App\Models\Notificacion_I; use App\Models\Notificacion_D; use App\Models\Notificacion_H;
use DB;


class OfertaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $ofertas = DB::table('oferta')
                    ->where([
                        ['tipo_creador', '=', session('perfilTipo')],
                        ['creador_id', '=', session('perfilId')],
                    ])
                    ->paginate(6);

        return view('oferta.index')->with(compact('ofertas'));
    }

    public function create()
    {   

    }

    public function crear_oferta($id, $producto){ 
        if ($id != '0'){
            $tipo = '1';
        }else{
            $tipo = '2';
        }

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        if ( session('perfilTipo') == 'P'){
            $marcas = DB::table('marca')
                        ->orderBy('nombre')
                        ->where('productor_id', '=', session('perfilId'))
                        ->pluck('nombre', 'id');
        }elseif ( session('perfilTipo') == 'I'){
             $marcas = DB::table('marca')
                    ->leftjoin('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                    ->where('importador_marca.importador_id', '=', session('perfilId'))
                    ->pluck('marca.nombre', 'marca.id');
        }else{
            $marcas = DB::table('marca')
                    ->leftjoin('distribuidor_marca', 'marca.id', '=', 'distribuidor_marca.marca_id')
                    ->where('distribuidor_marca.distribuidor_id', '=', session('perfilId'))
                    ->pluck('marca.nombre', 'marca.id');
        }

        return view('oferta.create')->with(compact('id', 'producto', 'paises', 'marcas', 'tipo'));
    }

    public function store(Request $request)
    {
        $fecha = new \DateTime();

        if ( (session('perfilSuscripcion') == 'G') || (session('perfilSuscripcion') == 'B') ){
            $creditos = 1;
        }else{
            $creditos = 0;
        }

        $oferta = new Oferta($request->all());
        $oferta->save();

        $ult_oferta = DB::table('oferta')
                        ->select('id')
                        ->orderBy('id', 'DESC')
                        ->get()
                        ->first();

        if ( $request->opciones == "P"){
            for ($i=0; $i<count($request->provincias); $i++){
                $destino = new Destino_Oferta();
                $destino->oferta_id = $ult_oferta->id;
                $destino->pais_id = $request->pais_id;
                $destino->provincia_region_id = $request->provincias[$i];
                $destino->save();
            }
        }else{
            $provincias = DB::table('provincia_region')
                            ->select('id')
                            ->where('pais_id', '=', $request->pais_id)
                            ->get();

            foreach ($provincias as $provincia){
                $destino = new Destino_Oferta();
                $destino->oferta_id = $ult_oferta->id;
                $destino->pais_id = $request->pais_id;
                $destino->provincia_region_id = $provincia->id;
                $destino->save();
            }
        }

        $producto = DB::table('producto')
                    ->select('nombre')
                    ->where('id', '=', $request->producto_id)
                    ->first();

        if ($request->visible_importadores == '1'){
            $importadores = DB::table('importador')
                                ->select('id')
                                ->where('pais_id', '=', $request->pais_id)
                                ->get();
            $cont=0;
            foreach ($importadores as $importador){
                $cont++;
            }

            if ($cont > 0){
                foreach ($importadores as $importador){
                    $notificaciones_importador = new Notificacion_I();
                    $notificaciones_importador->creador_id = session('perfilId');
                    $notificaciones_importador->tipo_creador = session('perfilTipo');
                    $notificaciones_importador->titulo = 'Hay una nueva oferta disponible de '.$producto->nombre.' para tu país.';
                    $notificaciones_importador->url='oferta/'.$ult_oferta->id;
                    $notificaciones_importador->importador_id = $importador->id;
                    $notificaciones_importador->descripcion = 'Nueva Oferta';
                    $notificaciones_importador->color = 'bg-purple';
                    $notificaciones_importador->icono = 'fa fa-asterisk';
                    $notificaciones_importador->fecha = $fecha;
                    $notificaciones_importador->save();   
                }        
            }
        }

        if ($request->visible_distribuidores == '1'){
            $distribuidores = DB::table('distribuidor')
                                ->select('id')
                                ->where('pais_id', '=', $request->pais_id)
                                ->get();
            $cont=0;
            foreach ($distribuidores as $distribuidor){
                $cont++;
            }

            if ($cont > 0){
                foreach ($distribuidores as $distribuidor){
                    $notificaciones_distribuidor = new Notificacion_D();
                    $notificaciones_distribuidor->creador_id = session('perfilId');
                    $notificaciones_distribuidor->tipo_creador = session('perfilTipo');
                    $notificaciones_distribuidor->titulo = 'Hay una nueva oferta disponible de '.$producto->nombre.' para tu país.';
                    $notificaciones_distribuidor->url='oferta/'.$ult_oferta->id;
                    $notificaciones_distribuidor->distribuidor_id = $distribuidor->id;
                    $notificaciones_distribuidor->descripcion = 'Nueva Oferta';
                    $notificaciones_distribuidor->color = 'bg-purple';
                    $notificaciones_distribuidor->icono = 'fa fa-asterisk';
                    $notificaciones_distribuidor->fecha = $fecha;
                    $notificaciones_distribuidor->save();   
                }        
            }
        }

        if ($request->visible_horecas == '1'){
            $horecas = DB::table('horeca')
                                ->select('id')
                                ->where('pais_id', '=', $request->pais_id)
                                ->get();
            $cont=0;
            foreach ($horecas as $horeca){
                $cont++;
            }

            if ($cont > 0){
                foreach ($horecas as $horeca){
                    $notificaciones_horeca = new Notificacion_H();
                    $notificaciones_horeca->creador_id = session('perfilId');
                    $notificaciones_horeca->tipo_creador = session('perfilTipo');
                    $notificaciones_horeca->titulo = 'Hay una nueva oferta disponible de '.$producto->nombre.' para tu país.';
                    $notificaciones_horeca->url='oferta/'.$ult_oferta->id;
                    $notificaciones_horeca->horeca_id = $horeca->id;
                    $notificaciones_horeca->descripcion = 'Nueva Oferta';
                    $notificaciones_horeca->color = 'bg-purple';
                    $notificaciones_horeca->icono = 'fa fa-asterisk';
                    $notificaciones_horeca->fecha = $fecha;
                    $notificaciones_horeca->save();   
                }        
            }
        }

        if ($creditos == '1'){
            $url = ('credito/gastar-creditos-co/25/'.$ult_oferta->id);
            return redirect($url); 
        }else{
             return redirect('oferta')->with('msj', 'Su oferta ha sido creada exitosamente');
        }    
    }

    public function show($id)
    {
        $oferta = Oferta::find($id);

        $destinos = Destino_Oferta::where('oferta_id', '=', $id)
                                ->orderBy('provincia_region_id')
                                ->select('pais_id', 'provincia_region_id')
                                ->get();

        return view('oferta.show')->with(compact('oferta', 'destinos'));   
    }

    public function edit($id)
    {
       
    }

    public function update(Request $request, $id)
    {   
        $oferta = Oferta::find($id);
        $oferta->fill($request->all());
        $oferta->save();

        $url = 'oferta/'.$id;
        return redirect($url)->with('msj', 'Los datos de su oferta han sido actualizados exitosamente');
    }

    public function destroy($id)
    {

    }
}
