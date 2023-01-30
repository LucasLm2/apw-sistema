<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use App\Models\Segurado;
use App\Http\Requests\StoreSeguradoRequest;
use App\Http\Requests\UpdateSeguradoRequest;

class SeguradoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cadastros.segurado.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFornecedorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSeguradoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Segurado  $segurado
     * @return \Illuminate\Http\Response
     */
    public function show(Segurado $segurado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Segurado  $segurado
     * @return \Illuminate\Http\Response
     */
    public function edit(Segurado $segurado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSeguradoRequest  $request
     * @param  \App\Models\Segurado  $segurado
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSeguradoRequest $request, Segurado $segurado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Segurado  $segurado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Segurado $segurado)
    {
        //
    }
}
