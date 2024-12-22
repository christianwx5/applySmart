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


// Definir la ruta personalizada para inactivar
Route::patch('JobOffers/{JobOffer}/inactivate', 'JobOffer\JobOfferController@inactivate')->name('JobOffers.inactivate');

// Definir la ruta personalizada para activar
Route::patch('JobOffers/{JobOffer}/activate', 'JobOffer\JobOfferController@activate')->name('JobOffers.activate');

// Rustas de acciones RESTful estándar
Route::resource('JobOffers', 'JobOffer\JobOfferController');
    // ->middleware('auth')
    // ->except('show');

Route::resource('companies', 'CompanyController');

Route::patch('companies/{company}/activate', 'CompanyController@activate')->name('companies.activate');
Route::patch('companies/{company}/deactivate', 'CompanyController@deactivate')->name('companies.deactivate');
