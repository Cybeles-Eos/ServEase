<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('front.pages.custom-pages.home');
});
