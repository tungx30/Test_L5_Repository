<?php

namespace Packages\Permission;

use Illuminate\Support\Facades\Route;
use Packages\Permission\Http\Controllers\RoleController;

class RouteRegistrar
{
    /**
     * The namespace implementation.
     */
    protected static $namespace = '\Packages\Permission\Http\Controllers';

    /**
     * Register routes for bread.
     *
     * @return void
     */
    public function all()
    {
        $this->roles();
    }

    public static function roles () {
        Route::group(['middleware' => []], function ($router) {
            Route::get('roles', [RoleController::class,'index'])->name('roles.show');
        });
    }
}
