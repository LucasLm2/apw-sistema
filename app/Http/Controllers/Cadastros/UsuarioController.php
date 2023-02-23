<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    function __construct()
    {
        $this->middleware(
            'permission:usuario-listar|usuario-cadastrar|usuario-editar|usuario-inativar|usuario-deletar', 
            ['only' => ['index','store']]
        );
        $this->middleware('permission:usuario-cadastrar', ['only' => ['create','store']]);
        $this->middleware('permission:usuario-editar', ['only' => ['edit','update']]);
        $this->middleware('permission:usuario-inativar', ['only' => ['inativos','inativarAtivar']]);
        $this->middleware('permission:usuario-deletar', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $users = Cache::rememberForever('usuarios', function () {
            return User::select('id', 'name', 'email')->where('ativo', '=', true)->orderBy('id','DESC')->get();
        });

        return view('cadastros.usuario.index')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $roles = Cache::rememberForever('select-permissoes', function () {
            return Role::select('id', 'name')->get();
        });
        
        return view('cadastros.usuario.create-edit')
            ->with('roles', $roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Cache::forget('usuarios');

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|same:password_confirmation',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
    
        return to_route('cadastro.usuario.index')
                        ->with('success',"Usuário '{$user->name}' adicionado com sucesso.");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $user = User::find($id);
        $roles = Cache::rememberForever('select-permissoes', function () {
            return Role::select('id', 'name')->get();
        });
        
        $userRoles = $user->roles->pluck('id')->all();
    
        return view('cadastros.usuario.create-edit')
            ->with('user', $user)
            ->with('roles', $roles)
            ->with('userRoles', $userRoles);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|min:8|same:password_confirmation',
            'roles' => 'required'
        ]);

        Cache::forget('usuarios');
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }
    
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('cadastro.usuario.index')
            ->with('success',"Usuário '{$user->name}' atualizado com sucesso.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        Cache::forget('usuarios-inativos');

        $user = User::find($id);
        $user->delete();

        return redirect()->route('cadastro.usuario.index')
            ->with('success', "Usuário '{$user->name}' excluido com sucesso.");
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function inativos(): View
    {
        $users = Cache::rememberForever('usuarios-inativos', function () {
            return User::where('ativo', '=', false)->orderBy('id','DESC')->get();
        });

        return view('cadastros.usuario.inativos')
            ->with('users', $users);
    }

    /**
     * Update the specified resource in storage.
     */
    public function inativarAtivar(int $id): RedirectResponse
    {
        Cache::forget('usuarios');
        Cache::forget('usuarios-inativos');

        $user = User::find($id);
        if($user->ativo) {
            $user->ativo = false;

            $messagem = "Usuário '{$user->name}' inativado com sucesso.";
        } else {
            $user->ativo = true;

            $messagem = "Usuário '{$user->name}' ativado com sucesso.";
        }
        
        $user->save();
        
        return to_route('cadastro.usuario.index')
            ->with('success', $messagem);
    }
}
