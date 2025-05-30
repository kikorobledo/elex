<?php

use App\Livewire\Admin\Roles;
use App\Livewire\Admin\Permisos;
use App\Livewire\Admin\Usuarios;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Secciones;
use App\Livewire\Admin\Referentes;
use App\Livewire\Settings\Profile;
use App\Livewire\Reportes\Reportes;
use App\Livewire\Settings\Password;
use App\Livewire\Referidos\Referido;
use App\Livewire\Referidos\Referidos;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SetPasswordController;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::middleware(['auth', 'esta.activo'])->group(function () {

    Route::get('dashboard', Dashboard::class)->name('dashboard');

    Route::get('roles', Roles::class)->name('roles');

    Route::get('permisos', Permisos::class)->name('permisos');

    Route::get('usuarios', Usuarios::class)->name('usuarios');

    Route::get('secciones', Secciones::class)->name('secciones');

    Route::get('referentes', Referentes::class)->name('referentes');

    Route::get('referidos', Referidos::class)->name('referidos');

    Route::get('referido/{referido}', Referido::class)->name('referido');

    Route::get('reportes', Reportes::class)->middleware('permission:Reportes')->name('reportes');

    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

});

Route::get('setpassword/{email}', [SetPasswordController::class, 'create'])->name('setpassword');
Route::post('setpassword', [SetPasswordController::class, 'store'])->name('setpassword.store');

require __DIR__.'/auth.php';
