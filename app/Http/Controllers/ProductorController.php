<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productor;
use App\Models\Pais;

class ProductorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productores = Productor::paginate(1);
        return view('productor.index')->with(compact('productores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $paises = Pais::all();
        return view('productor.create')->with(compact('paises'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $productor = new Productor($request->all());
        $productor->save();
        return redirect()->action('ProductorController@index');  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $productor = Productor::find($id);
       $paises = Pais::all();

       return view('productor.edit')->with(compact('productor','pais'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $productor = Productor::find($id);
        $productor->fill($request->all());
        $productor->save();

        return redirect()->action('ProductorController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productor = Productor::find($id);
        $productor->delete();

        return redirect()->action('ProductorController@index');
    }
}
