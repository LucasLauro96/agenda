<?php

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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('home', function(){
    return redirect('/');
});

//Rotas da categoria
Route::resource('category', 'CategoryController');

//Rotas de contatos
Route::resource('person', 'PersonController');
Route::post('/search/person', 'PersonController@search')->name('person.search');

//Rotas do telefone
Route::prefix('phone')->group(function(){
    Route::get('/{id}', 'PhoneController@index')->name('phone.index');
    Route::post('/', 'PhoneController@store')->name('phone.store');
    Route::get('/edit/{id}', 'PhoneController@edit')->name('phone.edit');
    Route::put('/update/', 'PhoneController@update')->name('phone.update');
    Route::delete('/{id}', 'PhoneController@destroy')->name('phone.destroy');
});

//Rotas do telefone
Route::prefix('address')->group(function(){
    Route::get('/{id}', 'AddressController@index')->name('address.index');
    Route::post('/', 'AddressController@store')->name('address.store');
    Route::get('/edit/{id}', 'AddressController@edit')->name('address.edit');
    Route::put('/update/', 'AddressController@update')->name('address.update');
    Route::delete('/{id}', 'AddressController@destroy')->name('address.destroy');
});