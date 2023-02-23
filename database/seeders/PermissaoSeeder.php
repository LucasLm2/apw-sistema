<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            'cadastros',
        ];

        $usuario = [
            'cadastro-usuario',
            'usuario-listar',
            'usuario-cadastrar',
            'usuario-editar',
            'usuario-inativar',
            'usuario-deletar',
        ];

        $tipoServico = [
            'cadastro-tipo-servico',
            'tipo-servico-listar',
            'tipo-servico-cadastrar',
            'tipo-servico-editar',
            'tipo-servico-inativar',
            'tipo-servico-deletar',
        ];

        $tipoDespesa = [
            'cadastro-tipo-despesa',
            'tipo-despesa-listar',
            'tipo-despesa-cadastrar',
            'tipo-despesa-editar',
            'tipo-despesa-inativar',
            'tipo-despesa-deletar',
        ];

        $seguradora = [
            'cadastro-seguradora',
            'seguradora-listar',
            'seguradora-cadastrar',
            'seguradora-editar',
            'seguradora-inativar',
            'seguradora-deletar',
        ];

        $reguladora = [
            'cadastro-reguladora',
            'reguladora-listar',
            'reguladora-cadastrar',
            'reguladora-editar',
            'reguladora-inativar',
            'reguladora-deletar',
        ];

        $cliente = [
            'cadastro-cliente',
            'cliente-listar',
            'cliente-cadastrar',
            'cliente-editar',
            'cliente-inativar',
            'cliente-deletar',
        ];

        $permissions = array_merge(
            $menus,
            $usuario, 
            $tipoServico, 
            $tipoDespesa, 
            $seguradora, 
            $reguladora, 
            $cliente
        );
      
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}
