<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MunicipiosPorUfRequest;
use App\Models\Endereco\Municipio;
use Illuminate\Support\Facades\Cache;

class IbgeController extends Controller
{
    public function listarMunicipiosPorUf(MunicipiosPorUfRequest $request)
    {
        $uf = $request->uf;
        $resultadoConsulta = Cache::rememberForever("municipios-$uf", function () use($uf) {
            return Municipio::findByEstado($uf);
        });

        if($resultadoConsulta === null) {
            return response()->json($this->formataMensagemErro(), 404);
        }

        return response()->json($resultadoConsulta, 200);
    }

    private function formataMensagemErro(): array
    {
        return [
            'message' => 'Municípios não encontrados.'                
        ];
    }
}
