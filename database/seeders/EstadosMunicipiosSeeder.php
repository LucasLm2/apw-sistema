<?php

namespace Database\Seeders;
use App\Models\Endereco\Estado;
use App\Models\Endereco\Municipio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class EstadosMunicipiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $informacoesMunicipios = json_decode(Http::get(config("app.api_ibge") . 'v1/localidades/municipios'));

        $estados = [];
        $municipios = [];
        foreach ($informacoesMunicipios as $municipio) {

            $uf = $municipio->microrregiao->mesorregiao->UF;
            if(!isset($estados[$uf->id])) {
                $estados[$uf->id] = [
                    'cod_ibge' => $uf->id, 
                    'uf' => $uf->sigla, 
                    'nome'=> $uf->nome, 
                ];
            }

            if(isset($municipios[$municipio->id])) {
                continue;
            }

            $municipios[$municipio->id] = [
                'cod_ibge' => $municipio->id, 
                'nome' => $municipio->nome,
                'estado_cod_ibge' => $uf->id
            ];
        }

        Estado::upsert(
            $estados, 
            ['cod_ibge'], 
            ['uf', 'nome']
        );

        Municipio::upsert(
            $municipios, 
            ['cod_ibge'], 
            ['nome', 'estado_cod_ibge']
        );
    }
}
