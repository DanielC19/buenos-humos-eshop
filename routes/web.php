<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get(uri: '/', action: 'App\Http\Controllers\HomeController@index')->name("home.index");

Auth::routes();