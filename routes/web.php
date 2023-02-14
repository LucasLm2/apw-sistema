<?php

use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Cadastros\ReguladoraController;
use App\Http\Controllers\Cadastros\SeguradoController;
use App\Http\Controllers\Cadastros\SeguradoraController;
use App\Http\Controllers\Cadastros\TipoDespesaController;
use App\Http\Controllers\Cadastros\TipoServicoController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
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

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // Cadastros
    Route::prefix('cadastro')->group(function () {
        Route::name('cadastro.')->group(function () {
            Route::resource('reguladora', ReguladoraController::class)->except('show');
            Route::prefix('/reguladora')->group(function () {
                Route::name('reguladora.')->group(function () {
                    Route::get('/inativos', [ReguladoraController::class, 'inativos'])->name('inativos');
                    Route::put('/{reguladora}/inativar-ativar', [ReguladoraController::class, 'inativarAtivar'])
                        ->name('inativar-ativar');
                });
            });

            Route::resource('seguradora', SeguradoraController::class)->except('show');
            Route::put('/seguradora/{seguradora}/inativar-ativar', [SeguradoraController::class, 'inativarAtivar'])
                ->name('seguradora.inativar-ativar');

            Route::resource('segurado', SeguradoController::class)->except('show');
            Route::put('/segurado/{segurado}/inativar-ativar', [SeguradoController::class, 'inativarAtivar'])
                ->name('segurado.inativar-ativar');

            Route::resource('tipo-despesa', TipoDespesaController::class)->except('show');
            Route::put('/tipo-despesa/{tipoDespesa}/inativar-ativar', [TipoDespesaController::class, 'inativarAtivar'])
                ->name('tipo-despesa.inativar-ativar');

            Route::resource('tipo-servico', TipoServicoController::class)->except('show');
            Route::put('/tipo-servico/{tipoServico}/inativar-ativar', [TipoServicoController::class, 'inativarAtivar'])
                ->name('tipo-servico.inativar-ativar');
        });
    });
});