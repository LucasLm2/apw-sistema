<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use App\Models\TipoDespesa;
use App\Http\Requests\StoreTipoDespesaRequest;
use App\Http\Requests\UpdateTipoDespesaRequest;

class TipoDespesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cadastros.tipo-despesa.index');
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
    public function store(StoreTipoDespesaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipoDespesa  $tipoDespesa
     * @return \Illuminate\Http\Response
     */
    public function show(TipoDespesa $tipoDespesa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TipoDespesa  $tipoDespesa
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoDespesa $tipoDespesa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTipoDespesaRequest  $request
     * @param  \App\Models\TipoDespesa  $tipoDespesa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTipoDespesaRequest $request, TipoDespesa $tipoDespesa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoDespesa  $tipoDespesa
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoDespesa $tipoDespesa)
    {
        //
    }
}
