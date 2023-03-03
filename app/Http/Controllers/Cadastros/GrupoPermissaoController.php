<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GrupoPermissaoController extends Controller
{
    function __construct()
    {
        $this->middleware(
            'permission:grupo-permissao-listar|grupo-permissao-cadastrar|grupo-permissao-editar|grupo-permissao-inativar|grupo-permissao-deletar',
            ['only' => ['index','store']]
        );
        $this->middleware('permission:grupo-permissao-cadastrar', ['only' => ['create','store']]);
        $this->middleware('permission:grupo-permissao-editar', ['only' => ['edit','update']]);
        $this->middleware('permission:grupo-permissao-inativar', ['only' => ['inativos','inativarAtivar']]);
        $this->middleware('permission:grupo-permissao-deletar', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $gruposPermissoes = Cache::rememberForever('grupo-permissao', function () {
            return Role::select('id', 'name')->where('ativo', '=', true)->orderBy('id','DESC')->get();
        });

        return view('cadastros.grupo-permissao.index')
            ->with('gruposPermissoes', $gruposPermissoes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $permissoes = Permission::select('id', 'name')->get();
        return view('cadastros.grupo-permissao.create-edit')
            ->with('permissoes', $permissoes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
    
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
    
        return redirect()->route('cadastro.grupo-permissao.index')
                        ->with('success','Role created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
    
        return view('cadastros.grupo-permissao.edit',compact('role','permission','rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);
    
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
    
        $role->syncPermissions($request->input('permission'));
    
        return redirect()->route('cadastro.grupo-permissao.index')
                        ->with('success','Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        Cache::forget('grupo-permissao-inativos');
        
        $grupoPermissao = Role::find($id);
        $grupoPermissao->delete();
        
        return redirect()->route('cadastro.grupo-permissao.index')
            ->with('success', "Grupo de permissão '{$grupoPermissao->name}' excluido com sucesso.");
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function inativos(): View
    {
        $gruposPermissoes = Cache::rememberForever('grupo-permissao-inativos', function () {
            return Role::select('id', 'name')->where('ativo', '=', false)->orderBy('id','DESC')->get();
        });

        return view('cadastros.grupo-permissao.inativos')
            ->with('gruposPermissoes', $gruposPermissoes);
    }

    /**
     * Update the specified resource in storage.
     */
    public function inativarAtivar(int $id): RedirectResponse
    {
        Cache::forget('grupo-permissao');
        Cache::forget('grupo-permissao-inativos');

        $grupoPermissao = Role::find($id);
        if($grupoPermissao->ativo) {
            $grupoPermissao->ativo = false;

            $messagem = "Grupo de permissão '{$grupoPermissao->name}' inativado com sucesso.";
        } else {
            $grupoPermissao->ativo = true;

            $messagem = "Grupo de permissão '{$grupoPermissao->name}' ativado com sucesso.";
        }
        
        $grupoPermissao->save();
        
        return to_route('cadastro.grupo-permissao.index')
            ->with('success', $messagem);
    }
}
