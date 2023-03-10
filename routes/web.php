<?php

use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Cadastros\ReguladoraController;
use App\Http\Controllers\Cadastros\ClienteController;
use App\Http\Controllers\Cadastros\GrupoPermissaoController;
use App\Http\Controllers\Cadastros\SeguradoraController;
use App\Http\Controllers\Cadastros\TipoDespesaController;
use App\Http\Controllers\Cadastros\TipoServicoController;
use App\Http\Controllers\Cadastros\UsuarioController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']);
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
    Route::post('/password/confirm', [ConfirmPasswordController::class, 'confirm']);


    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // Cadastros
    Route::prefix('cadastro')->group(function () {
        Route::name('cadastro.')->group(function () {

            Route::resource('grupo-permissao', GrupoPermissaoController::class)->except('show');
            Route::prefix('/grupo-permissao')->group(function () {
                Route::name('grupo-permissao.')->group(function () {
                    Route::get('/inativos', [GrupoPermissaoController::class, 'inativos'])->name('inativos');
                    Route::put('/{grupoPermissao}/inativar-ativar', [GrupoPermissaoController::class, 'inativarAtivar'])
                        ->name('inativar-ativar');
                });
            });

            Route::resource('usuario', UsuarioController::class)->except('show');
            Route::prefix('/usuario')->group(function () {
                Route::name('usuario.')->group(function () {
                    Route::get('/inativos', [UsuarioController::class, 'inativos'])->name('inativos');
                    Route::put('/{usuario}/inativar-ativar', [UsuarioController::class, 'inativarAtivar'])
                        ->name('inativar-ativar');
                });
            });

            Route::resource('reguladora', ReguladoraController::class)->except('show');
            Route::prefix('/reguladora')->group(function () {
                Route::name('reguladora.')->group(function () {
                    Route::get('/inativos', [ReguladoraController::class, 'inativos'])->name('inativos');
                    Route::put('/{reguladora}/inativar-ativar', [ReguladoraController::class, 'inativarAtivar'])
                        ->name('inativar-ativar');
                });
            });

            Route::resource('seguradora', SeguradoraController::class)->except('show');
            Route::prefix('/seguradora')->group(function () {
                Route::name('seguradora.')->group(function () {
                    Route::get('/inativos', [SeguradoraController::class, 'inativos'])->name('inativos');
                    Route::put('/{seguradora}/inativar-ativar', [SeguradoraController::class, 'inativarAtivar'])
                        ->name('inativar-ativar');
                });
            });


            Route::resource('cliente', ClienteController::class)->except('show');
            Route::prefix('/cliente')->group(function () {
                Route::name('cliente.')->group(function () {
                    Route::get('/inativos', [ClienteController::class, 'inativos'])->name('inativos');
                    Route::put('/{cliente}/inativar-ativar', [ClienteController::class, 'inativarAtivar'])
                        ->name('inativar-ativar');
                });
            });
            
            Route::resource('tipo-despesa', TipoDespesaController::class)->except('show');
            Route::prefix('/tipo-despesa')->group(function () {
                Route::name('tipo-despesa.')->group(function () {
                    Route::get('/inativos', [TipoDespesaController::class, 'inativos'])->name('inativos');
                    Route::put('/{tipoDespesa}/inativar-ativar', [TipoDespesaController::class, 'inativarAtivar'])
                        ->name('inativar-ativar');
                });
            });

            Route::resource('tipo-servico', TipoServicoController::class)->except('show');
            Route::prefix('/tipo-servico')->group(function () {
                Route::name('tipo-servico.')->group(function () {
                    Route::get('/inativos', [TipoServicoController::class, 'inativos'])->name('inativos');
                    Route::put('/{tipoServico}/inativar-ativar', [TipoServicoController::class, 'inativarAtivar'])
                        ->name('inativar-ativar');
                });
            });
        });
    });
});