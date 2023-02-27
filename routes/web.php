<?php

use App\Http\Controllers\BillingMonitoringController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\Po_monitorController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BiphController;
use App\Http\Controllers\BivnController;
use App\Http\Controllers\CancelledController;
use App\Http\Controllers\DccBcController;
use App\Http\Controllers\DccBhController;
use App\Http\Controllers\DccUhdController;
use App\Http\Controllers\K1Controller;
use App\Http\Controllers\PantumController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductModelController;
use App\Http\Controllers\PsnmController;
use App\Http\Controllers\TransferInventoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\User;

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
    return view('/auth.login');
});
Route::get('/', [LoginController::class, 'index']);

Route::get('/countries-list', [CountriesController::class, 'index'])->name('countries.list');
Route::post('/add-country', [CountriesController::class,'addCountry'])->name('add.country');
Route::get('/getCountriesList', [CountriesController::class, 'getCountriesList'])->name('get.countries.list');
Route::post('/getCountryDetails', [CountriesController::class, 'getCountryDetails'])->name('get.country.details');
Route::post('/updateCountryDetails', [CountriesController::class, 'updateCountryDetails'])->name('update.country.details');
Route::post('/deleteCountry', [CountriesController::class, 'deleteCountry'])->name('delete.country');
Route::post('/deleteSelectedCountries', [CountriesController::class, 'deleteSelectedCountries'])->name('delete.selected.countries');

// Route::get('/leftjoin',[BillingMonitoringController::class,'show'])->name('left.join');
Route::middleware(['middleware'=>'PreventBackHistory'])->group(function (){
    Auth::routes([
    ]);
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['prefix'=>'admin', 'middleware'=>['isAdmin','auth','PreventBackHistory']], function(){
    Route::get('dashboard',[AdminController::class,'index'])->name('admin.dashboard');

    Route::get('add-account',[AdminController::class, 'addAccount'])->name('admin.addAccount');

    Route::get('sample', [Po_monitorController::class, 'samplefetch'])->name('sample');
    Route::get('add-po', [Po_monitorController::class, 'addPO'])->name('add.po');    
    Route::post('submitAddPO', [Po_monitorController::class, 'submitAddPO'])->name('submit.add');
    Route::get('getPOLIST', [Po_monitorController::class, 'getPOLIST'])->name('get.po.list');
    Route::post('get-po', [Po_monitorController::class, 'edit'])->name('get.po.edit');
    Route::post('update-po', [Po_monitorController::class, 'update'])->name('get.po.update');
    Route::post('delete-po', [Po_monitorController::class, 'destroy'])->name('delete.po');

    Route::post('transfer-inventory', [TransferInventoryController::class, 'create'])->name('transfer.inventory');

    Route::get('billed-po',[BillingMonitoringController::class, 'index'])->name('billed.list');
    Route::post('submitbill',[BillingMonitoringController::class,'create'])->name('submit.bill');
    Route::post('edit-bill',[BillingMonitoringController::class,'edit'])->name('edit.bill');
    Route::post('update-bill',[BillingMonitoringController::class,'update'])->name('update.bill');
    Route::get('listbill',[BillingMonitoringController::class,'show'])->name('list.bill');


    Route::get('add-model',[ProductModelController::class, 'index'])->name('add.model.products');
    Route::post('createModel', [ProductModelController::class, 'create'])->name('create.model');
    Route::get('list-model',[ProductModelController::class, 'show'])->name('list.model');
    Route::post('edit-model', [ProductModelController::class, 'edit'])->name('edit.model.product');
    Route::post('update-model', [ProductModelController::class, 'update'])->name('update.model');
    Route::post('delete-model', [ProductModelController::class, 'destroy'])->name('delete.model');

    Route::get('product', [ProductController::class, 'index'])->name('product');
    Route::post('create-product', [ProductController::class, 'create'])->name('create.product');
    Route::get('list-product', [ProductController::class, 'show'])->name('list.product');
    Route::post('edit-product', [ProductController::class, 'edit'])->name('edit.product');
    Route::post('update-product', [ProductController::class, 'updateProduct'])->name('update.product');
    Route::post('delete-product', [ProductController::class, 'destroy'])->name('delete.product');

    Route::get('biph', [BiphController::class, 'index'])->name('biph');
    Route::get('biph-list', [BiphController::class, 'fetchBIPH'])->name('list.biph');
    Route::get('biph-po', [BiphController::class,'biphPo'])->name('biph.po');
    Route::get('biph-po-list', [Po_monitorController::class,'getPOBiph'])->name('po.list.biph');
    
    
    Route::get('bivn', [BivnController::class,'index'])->name('bivn');
    Route::get('bivn-list', [BivnController::class, 'fetchBivn'])->name('list.bivn');
    Route::get('bivn-po', [BivnController::class, 'poBivn'])->name('bivn.po');
    Route::get('bivn-po-list', [Po_monitorController::class, 'getPOBivn'])->name('po.list.bivn');

    Route::get('pantum', [PantumController::class, 'index'])->name('pantum');
    Route::get('pantum-list', [PantumController::class,'list'])->name('list.pantum');
    Route::get('pantum-po', [PantumController::class, 'poPantum'])->name('pantum.po');
    Route::get('pantum-po-list', [Po_monitorController::class, 'getPOPantum'])->name('po.list.pantum');

    Route::get('dcc-bc', [DccBcController::class, 'index'])->name('dcc.bc');
    Route::get('dcc-bc-list', [DccBcController::class, 'list'])->name('dcc.bc.list');
    Route::get('dcc-bc-po', [DccBcController::class, 'poDccBc'])->name('dcc.bc.po');
    Route::get('dcc-bc-po-list', [Po_monitorController::class, 'getPODccBc'])->name('dcc.bc.po.list');

    Route::get('dcc-bh', [DccBhController::class, 'index'])->name('dcc.bh');
    Route::get('dcc-bh-list', [DccBhController::class, 'list'])->name('dcc.bh.list');
    Route::get('dcc-bh-po', [DccBhController::class, 'poDccBh'])->name('po.dcc.bh');
    Route::get('dcc-bh-po-list', [Po_monitorController::class, 'getPODccBh'])->name('po.list.dcc.bh');

    Route::get('dcc-uhd', [DccUhdController::class, 'index'])->name('dcc.uhd');
    Route::get('dcc-uhd-list', [DccUhdController::class, 'list'])->name('dcc.uhd.list');
    Route::get('dcc-uhd-po', [DccUhdController::class, 'poDccUhd'])->name('po.dcc.uhd');
    Route::get('dcc-uhd-po-list', [Po_monitorController::class, 'getPODccUhd'])->name('po.list.dcc.uhd');
    
    Route::get('psnm', [PsnmController::class, 'index'])->name('psnm');
    Route::get('psnm-list', [PsnmController::class, 'list'])->name('psnm.list');
    Route::get('psnm-po', [PsnmController::class, 'poPsnm'])->name('po.psnm');
    Route::get('psnm-po-list', [Po_monitorController::class, 'getPOPsnm'])->name('po.list.psnm');
    
    Route::get('k1', [K1Controller::class, 'index'])->name('k1');
    Route::get('k1-list', [K1Controller::class, 'list'])->name('k1.list');
    Route::get('k1-po', [K1Controller::class, 'poK1'])->name('po.k1');
    Route::get('k1-po-list', [Po_monitorController::class, 'getPOK1'])->name('po.list.k1');

    // cancelled feature

    Route::post('create-cancel', [ CancelledController::class,'create'])->name('create.cancel');
});