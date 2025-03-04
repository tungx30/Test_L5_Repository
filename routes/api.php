<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Packages\Auth\Http\Controllers\AdminController;
use Packages\Auth\RouteRegistrar as AuthRouteRegistrar;
use Packages\User\RouteRegistrar as UserRouteRegistrar;

//Account
AuthRouteRegistrar::routes();
//User
UserRouteRegistrar::routes();
