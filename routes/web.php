<?php

use Illuminate\Support\Facades\Route;


Route::get('/login', function(){
    return response()->json('Token inválido!');
})->name("login");
