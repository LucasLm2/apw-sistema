<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use App\Models\Reguladora;
use App\Http\Requests\StoreReguladoraRequest;
use App\Http\Requests\UpdateReguladoraRequest;

class ReguladoraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cadastros.reguladora.index');
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
    public function store(StoreReguladoraRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reguladora  $reguladora
     * @return \Illuminate\Http\Response
     */
    public function show(Reguladora $reguladora)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reguladora  $reguladora
     * @return \Illuminate\Http\Response
     */
    public function edit(Reguladora $reguladora)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReguladoraRequest  $request
     * @param  \App\Models\Reguladora  $reguladora
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReguladoraRequest $request, Reguladora $reguladora)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reguladora  $reguladora
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reguladora $reguladora)
    {
        //
    }
}
