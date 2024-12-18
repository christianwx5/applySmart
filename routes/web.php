<?php

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

use Illuminate\Http\Resources\Json\Resource;

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', function () {
    //return view('JobOffer/list');
    return view('welcome');
});

Route::get('/JobOffer/list', function () {
    return view('JobOffer/list');
});

Route::resource('JobOffers', 'JobOffer\JobOfferController');
    // ->middleware('auth')
    // ->except('show');