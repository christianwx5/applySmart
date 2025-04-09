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

Route::patch('JobOffers/updateJobOfferApplyStatus', 'JobOffer\JobOfferController@updateJobOfferApplyStatus')->name('JobOffers.updateJobOfferApplyStatus');


Route::get('JobOffers/list', 'JobOffer\JobOfferController@list')->name('JobOffers.list');

// Rustas de acciones RESTful estándar
Route::resource('JobOffers', 'JobOffer\JobOfferController')
    ->middleware('auth')
    /* ->except('index') */;

Route::resource('companies', 'CompanyController');

Route::patch('companies/{company}/activate', 'CompanyController@activate')->name('companies.activate');
Route::patch('companies/{company}/desactivate', 'CompanyController@desactivate')->name('companies.desactivate');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::resource('companies', 'CompanyController');


use App\Http\Controllers\JobPriorityController;

Route::resource('jobPriorities', 'JobPriorityController');

Route::patch('jobPriorities/{jobPriority}/activate', 'JobPriorityController@activate')->name('jobPriorities.activate');
Route::patch('jobPriorities/{jobPriority}/desactivate', 'JobPriorityController@desactivate')->name('jobPriorities.desactivate');


Route::get('testViews/test-api', function () {
    return view('testViews/test-api');
});

Route::get('testViews/test-api-adaptado', function () {
    return view('testViews/test-api-adaptado');
});

Route::get('testViews/test-draggable', function () {
    return view('testViews/test-draggable');
});