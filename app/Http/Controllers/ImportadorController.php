<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Importador; use App\Models\Distribuidor; use App\Models\User;
use App\Models\Pais; use App\Models\Provincia_Region; use App\Models\Marca;
use App\Models\Producto;
use App\Models\Bebida;
use App\Models\Productor;
use App\Models\Oferta;
use App\Models\Destino_Oferta;
use App\Models\Demanda_Distribuidor; use App\Models\Demanda_Producto;
use App\Models\Notificacion_P;
use DB; use Auth; use Input; use Image;

class ImportadorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        
    }

    public function create()
    {   
        
    }

    /*public function store(Request $request)
    {
        $file = Input::file('logo');   
        $image = Image::make(Input::file('logo'));

        $path = public_path().'/imagenes/importadores/';
        $path2 = public_path().'/imagenes/importadores/thumbnails/';
        $nombre = 'importador_'.time().'.'.$file->getClientOriginalExtension();

        $image->save($path.$nombre);
        $image->resize(240,200);
        $image->save($path2.$nombre);

        $importador = new Importador($request->all());
        $importador->logo = $nombre;
        $importador->save();

        if ( $request->who == 'U'){
             return redirect('usuario')->with('msj', 'Se ha registrado exitosamente su Importador');
        }else{
            $importador->productores()->attach(session('productorId'));
            $url = 'productor/'.session('productorId');
            return redirect($url)->with('msj', 'Se ha registrado exitosamente su Importador');
        }
    }*/

    public function show($id)
    {
        $importador = Importador::find($id);
        return view('importador.show')->with(compact('importador'));
    }

   /* public function edit($id)
    {
        $importador = Importador::find($id);

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->where('pais_id', '=', $importador->pais_id)
                        ->pluck('provincia', 'id');

       return view('importador.edit')->with(compact('importador', 'paises', 'provincias'));
    }

    public function update(Request $request, $id)
    {
        $importador = Importador::find($id);
        $importador->fill($request->all());
        $importador->save();

        $url = 'importador/'.$id.'/edit';
       return redirect($url)->with('msj', 'Su imagen de perfil ha sido cambiada con éxito');
    }

    public function updateAvatar(Request $request){
        $file = Input::file('logo');   
        $image = Image::make(Input::file('logo'));

        $path = public_path().'/imagenes/importadores/';
        $path2 = public_path().'/imagenes/importadores/thumbnails/';
        $nombre = 'importador_'.time().'.'.$file->getClientOriginalExtension();

        $image->save($path.$nombre);
        $image->resize(240,200);
        $image->save($path2.$nombre);

        $actualizacion = DB::table('importador')
                            ->where('id', '=', $request->id)
                            ->update(['logo' => $nombre ]);
       
       $url = 'importador/'.$request->id.'/edit';
       return redirect($url)->with('msj', 'Su imagen de perfil ha sido cambiada con éxito');
    }

    public function destroy($id)
    {

    }*/

     //FUNCION QUE LE PERMITE AL IMPORTADOR REGISTRAR UN DISTRIBUIDOR ASOCIADO
    /*public function registrar_distribuidor(){

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        return view('importador.registrarDistribuidor')->with(compact('paises'));
    }

    //FUNCION QUE PERMITE VER LOS DISTRIBUIDORES ASOCIADOS A UN IMPORTADOR
    public function ver_distribuidores(){
        $distribuidores = Importador::find(session('importadorId'))
                                    ->distribuidores()
                                    ->paginate(6);

        return view('importador.listados.distribuidores')->with(compact('distribuidores'));
    }

    //FUNCION QUE LE PERMITE AL IMPORTADOR REGISTRAR UNA MARCA
    public function registrar_marca(){

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        return view('importador.registrarMarca')->with(compact('paises'));
    }*/
    
    public function listado_marcas(){
        $accion = 'Asociar';

        $marcas = DB::table('marca')
                    ->select('marca.*')
                    ->leftjoin('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                    ->where('importador_marca.importador_id', '!=', session('perfilId'))
                    ->orwhere('importador_marca.marca_id', '=', null)
                    ->paginate(6);

        return view('importador.listados.marcasDisponibles')->with(compact('marcas', 'accion'));
    }

    public function asociar_marca($id){
        $fecha = new \DateTime();

        $marca = Marca::find($id);

        //Asociar importador a la marca
        $marca->importadores()->attach(session('perfilId'), ['status' => '0']);
        // ... //

        //Notificar al productor
        $url = 'notificacion/notificar-productor/AI/'.$marca->nombre.'/'.$marca->productor_id;
        return redirect($url);
        // ... //
       
        //return redirect('marca')->with('msj', 'Se ha agregado la marca a su lista. Debe esperar la confirmación del productor.');
    }

    /*//FUNCION QUE LE PERMITE AL IMPORTADOR REGISTRAR UN PRODUCTO ASOCIADO A SU MARCA 
    public function registrar_producto($id, $marca){

        $paises = DB::table('pais')
                    ->orderBy('pais')
                    ->pluck('pais', 'id');

        $clases_bebidas = DB::table('clase_bebida')
                    ->orderBy('clase')
                    ->pluck('clase', 'id');

        return view('importador.registrarProducto')->with(compact('id', 'marca', 'paises', 'clases_bebidas'));
    }*/

    //FUNCION QUE LE PERMITE AL IMPORTADOR VER EL LISTADO DE PRODUCTOS ASOCIADOS A UNA MARCA
    public function ver_productos($id, $marca){
        
        $productos = Marca::find($id)
                            ->productos()
                            ->paginate(8);

        return view('importador.listados.productos')->with(compact('productos', 'marca'));
    }

    public function ver_detalle_producto($id, $producto){
        $perfil = 'I';

        $producto = Producto::find($id);
        
        $bebida = Bebida::find($producto->clase_bebida->bebida_id)
                        ->select('nombre', 'caracteristicas')
                        ->get()
                        ->first();

        $productor = Productor::find($producto->marca->productor_id)
                        ->select('nombre')
                        ->get()
                        ->first();

        return view('importador.detalleProducto')->with(compact('producto', 'bebida', 'productor', 'perfil'));
    }

    public function listado_ofertas(){
        $importador = DB::table('importador')
                            ->where('id', '=', session('perfilId') )
                            ->select('pais_id')
                            ->get()
                            ->first();

        $ofertas = DB::table('oferta')
                    ->select('oferta.*')
                    ->join('destino_oferta', 'oferta.id', '=', 'destino_oferta.oferta_id')
                    ->where('oferta.visible_importadores', '=', '1')
                    ->where('destino_oferta.pais_id', '=', $importador->pais_id)
                    ->groupBy('oferta.id')
                    ->paginate(6);

        return view('importador.listados.ofertasDisponibles')->with(compact('ofertas'));
    }

    public function solicitar_importacion(){
        $accion = 'Solicitar';

        $marcas = DB::table('marca')
                    ->select('marca.*')
                    ->leftjoin('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                    ->where('importador_marca.importador_id', '!=', session('perfilId'))
                    ->orwhere('importador_marca.marca_id', '=', null)
                    ->paginate(6);

        return view('importador.listados.marcasDisponibles')->with(compact('marcas', 'accion'));
    }

    public function listado_distribuidores(){
        $pais_importador = DB::table('importador')
                            ->select('pais_id')
                            ->where('id', '=', session('perfilId'))
                            ->get()
                            ->first();

        $distribuidores = Distribuidor::orderBy('nombre')
                            ->select('nombre', 'pais_id', 'provincia_region_id', 'logo', 'persona_contacto')
                            ->where('pais_id', '=', $pais_importador->pais_id)
                            ->paginate(6);

        return view('importador.listados.distribuidoresPais')->with(compact('distribuidores'));
    }

}
