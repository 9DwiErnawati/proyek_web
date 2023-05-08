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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::resource('mst-pangkat','MstPangkatController');

Auth::routes();

Route::resource('mst-jabatan','MstJabatanController');

Auth::routes();

Route::resource('pegawai','PegawaiController'); 

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');

Route::get('/riwayat-pangkat','RiwayatPangkatController@index'); 
 
Route::get('/riwayat-pangkat/proses/{id}','RiwayatPangkatController@proses')            
            ->name('riwayat-pangkat.index1'); 
 
Route::get('/riwayat-pangkat/cetak/{id}','RiwayatPangkatController@cetak')            
            ->name('riwayat-pangkat.cetak'); 

Route::get('/riwayat-pangkat/create/{id}','RiwayatPangkatController@create'); 
 
Route::post('/riwayat-pangkat/store','RiwayatPangkatController@store')         
            ->name('riwayat-pangkat.store');          

Route::get('/riwayat-pangkat/{id}/edit','RiwayatPangkatController@edit') 
            ->name('riwayat-pangkat.edit');           
            
Route::patch('/riwayat-pangkat/update/{id}','RiwayatPangkatController@update')              
            ->name('riwayat-pangkat.update'); 
 
Route::get('/riwayat-pangkat/show/{id}','RiwayatPangkatController@show')          
            ->name('riwayat-pangkat.show');           
            
Route::delete('/riwayat-pangkat/destroy/{id}','RiwayatPangkatController@destroy')           
            ->name('riwayat-pangkat.destroy');