<?php

use App\Http\Controllers\Admin\BulletinController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\DispatchController;
use App\Http\Controllers\CommoditieController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ExitsController;
use App\Http\Controllers\ViaController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\Vias\DispatchController as ViasDispatchController;
use Illuminate\Support\Facades\Auth;
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
    return redirect()->route('login');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('read/{bulletin}', [App\Http\Controllers\HomeController::class, 'readBulletin'])->name('bulletins.read');

// Profile Routes
Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'getProfile'])->name('detail');
    Route::post('/update', [HomeController::class, 'updateProfile'])->name('update');
    Route::post('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
});

Route::group(['middleware' => ['role:Admin']], function () {
    // Roles
    Route::resource('roles', App\Http\Controllers\RolesController::class);

    // Permissions
    Route::resource('permissions', App\Http\Controllers\PermissionsController::class);

    // Users
    Route::middleware('auth')->prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
        Route::put('/update/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/delete/{user}', [UserController::class, 'delete'])->name('destroy');
        Route::get('/update/status/{user_id}/{status}', [UserController::class, 'updateStatus'])->name('status');


        Route::get('/import-users', [UserController::class, 'importUsers'])->name('import');
        Route::post('/upload-users', [UserController::class, 'uploadUsers'])->name('upload');

        Route::get('export/', [UserController::class, 'export'])->name('export');
    });


    Route::middleware('auth')->prefix('rate')->name('rate.')->group(function () {
        Route::get('/', [RateController::class, 'index'])->name('index');
        Route::get('/create', [RateController::class, 'create'])->name('create');
        Route::post('/store', [RateController::class, 'store'])->name('store');
        Route::get('/edit/{rate}', [RateController::class, 'edit'])->name('edit');
        Route::put('/update/{rate}', [RateController::class, 'update'])->name('update');
        Route::delete('/delete', [RateController::class, 'delete'])->name('destroy');
        Route::get('/update/status/{rate_id}/{active}', [RateController::class, 'updateStatus'])->name('status');


        Route::get('/import-users', [UserController::class, 'importUsers'])->name('import');
        Route::post('/upload-users', [UserController::class, 'uploadUsers'])->name('upload');

        Route::get('export/', [RateController::class, 'export'])->name('export');
    });

    Route::middleware('auth')->prefix('destination')->name('destination.')->group(function () {
        Route::get('/', [DestinationController::class, 'index'])->name('index');
        Route::get('/create', [DestinationController::class, 'create'])->name('create');
        Route::post('/store', [DestinationController::class, 'store'])->name('store');
        Route::get('/edit/{destination}', [DestinationController::class, 'edit'])->name('edit');
        Route::put('/update/{destination}', [DestinationController::class, 'update'])->name('update');
        Route::delete('/delete', [DestinationController::class, 'delete'])->name('destroy');
        Route::get('/update/status/{destination_id}/{active}', [DestinationController::class, 'updateStatus'])->name('status');


        Route::get('/import-users', [UserController::class, 'importUsers'])->name('import');
        Route::post('/upload-users', [UserController::class, 'uploadUsers'])->name('upload');

        Route::get('export/', [DestinationController::class, 'export'])->name('export');
    });

    Route::middleware('auth')->prefix('via')->name('via.')->group(function () {
        Route::get('/', [ViaController::class, 'index'])->name('index');
        Route::get('/create', [ViaController::class, 'create'])->name('create');
        Route::post('/store', [ViaController::class, 'store'])->name('store');
        Route::get('/edit/{via}', [ViaController::class, 'edit'])->name('edit');
        Route::put('/update/{via}', [ViaController::class, 'update'])->name('update');
        Route::delete('/delete', [ViaController::class, 'delete'])->name('destroy');
        Route::get('/update/status/{via_id}/{active}', [ViaController::class, 'updateStatus'])->name('status');


        Route::get('/import-users', [UserController::class, 'importUsers'])->name('import');
        Route::post('/upload-users', [UserController::class, 'uploadUsers'])->name('upload');

        Route::get('export/', [ViaController::class, 'export'])->name('export');
    });

    Route::middleware('auth')->prefix('exit')->name('exit.')->group(function () {
        Route::get('/', [ExitsController::class, 'index'])->name('index');
        Route::get('/create', [ExitsController::class, 'create'])->name('create');
        Route::post('/store', [ExitsController::class, 'store'])->name('store');
        Route::get('/edit/{exit}', [ExitsController::class, 'edit'])->name('edit');
        Route::put('/update/{exit}', [ExitsController::class, 'update'])->name('update');
        Route::delete('/delete', [ExitsController::class, 'delete'])->name('destroy');
        Route::get('/update/status/{exit_id}/{active}', [ExitsController::class, 'updateStatus'])->name('status');


        Route::get('/import-users', [UserController::class, 'importUsers'])->name('import');
        Route::post('/upload-users', [UserController::class, 'uploadUsers'])->name('upload');

        Route::get('export/', [ExitsController::class, 'export'])->name('export');
    });

    Route::middleware('auth')->prefix('supplier')->name('supplier.')->group(function () {
        Route::get('/', [SupplierController::class, 'index'])->name('index');
        Route::get('/create', [SupplierController::class, 'create'])->name('create');
        Route::post('/store', [SupplierController::class, 'store'])->name('store');
        Route::get('/edit/{supplier}', [SupplierController::class, 'edit'])->name('edit');
        Route::put('/update/{supplier}', [SupplierController::class, 'update'])->name('update');
        Route::delete('/delete', [SupplierController::class, 'delete'])->name('destroy');
        Route::get('/update/status/{supplier_id}/{active}', [SupplierController::class, 'updateStatus'])->name('status');

        Route::get('/exits/{supplier}', [SupplierController::class, 'exitindex'])->name('exitindex');
        Route::post('/exitstore', [SupplierController::class, 'exitstore'])->name('exitstore');
        Route::delete('/exit/delete/{supplier}', [SupplierController::class, 'suppexitdestroy'])->name('supplier-exit-destroy');


        Route::get('/import-users', [UserController::class, 'importUsers'])->name('import');
        Route::post('/upload-users', [UserController::class, 'uploadUsers'])->name('upload');

        Route::get('export/', [SupplierController::class, 'export'])->name('export');
    });

    Route::middleware('auth')->prefix('commoditie')->name('commoditie.')->group(function () {
        Route::get('/', [CommoditieController::class, 'index'])->name('index');
        Route::get('/create', [CommoditieController::class, 'create'])->name('create');
        Route::post('/store', [CommoditieController::class, 'store'])->name('store');
        Route::get('/edit/{commoditie}', [CommoditieController::class, 'edit'])->name('edit');
        Route::put('/update/{commoditie}', [CommoditieController::class, 'update'])->name('update');
        Route::delete('/delete', [CommoditieController::class, 'delete'])->name('destroy');
        Route::get('/update/status/{commoditie_id}/{active}', [CommoditieController::class, 'updateStatus'])->name('status');
        Route::get('/{commoditie}', [CommoditieController::class, 'supplierindex'])->name('supplierindex');
        Route::post('/supplierstore', [CommoditieController::class, 'supplierstore'])->name('supplierstore');
        Route::delete('/deletecommsupp/{commoditie}', [CommoditieController::class, 'commsuppdestroy'])->name('commsuppdestroy');


        Route::get('/import-users', [UserController::class, 'importUsers'])->name('import');
        Route::post('/upload-users', [UserController::class, 'uploadUsers'])->name('upload');

        Route::get('export/', [CommoditieController::class, 'export'])->name('export');
    });

    Route::middleware('auth')->prefix('dispatch')->name('dispatch.')->group(function () {
        Route::get('/searchview', [DispatchController::class, 'searchview'])->name('searchview');
        Route::get('/{date}', [DispatchController::class, 'index'])->name('index');
        Route::get('/create', [DispatchController::class, 'create'])->name('create');
        Route::post('/store', [DispatchController::class, 'store'])->name('store');
        Route::get('/edit/{dispatch}', [DispatchController::class, 'edit'])->name('edit');
        Route::post('/update', [DispatchController::class, 'update'])->name('update');
        Route::post('/bulkedit', [DispatchController::class, 'bulkedit'])->name('bulkedit');
        Route::delete('/delete', [DispatchController::class, 'delete'])->name('destroy');
        Route::get('/update/status/{dispatch_id}/{status}', [DispatchController::class, 'updateStatus'])->name('status');


        Route::get('/import-users', [DispatchController::class, 'importUsers'])->name('import');
        Route::post('/upload-users', [DispatchController::class, 'uploadUsers'])->name('upload');
        Route::get('export/', [DispatchController::class, 'export'])->name('export');

        /////////////Ajax Routes
        Route::post('/getCommoditieSuppliers', [DispatchController::class, 'getCommoditieSuppliers'])->name('getCommoditieSuppliers');
        Route::post('/getSuppliersExits', [DispatchController::class, 'getSuppliersExits'])->name('getSuppliersExits');
        Route::post('/getdispatch', [DispatchController::class, 'getdispatch'])->name('getdispatch');
        Route::post('/changelog', [DispatchController::class, 'changelog'])->name('changelog');
        Route::post('/changedisplay', [DispatchController::class, 'changedisplay'])->name('changedisplay');
        Route::post('/displaynotes', [DispatchController::class, 'changeNotesView'])->name('displaynotes');
        Route::post('/GetReleaseCode', [DispatchController::class, 'GetReleaseCode'])->name('GetReleaseCode');

        Route::post('/RealseCodeVefiry', [DispatchController::class, 'RealseCodeVefiry'])->name('RealseCodeVefiry');
        Route::match(['get', 'post'], '/searchresult', [DispatchController::class, 'searchresult'])->name('searchresult');
    });

    Route::middleware('auth')->prefix('config')->name('config.')->group(function () {
        Route::get('/', [ConfigController::class, 'index'])->name('index');
        Route::post('/store', [ConfigController::class, 'store'])->name('store');
        Route::get('/edit/{commoditie}', [ConfigController::class, 'edit'])->name('edit');
        Route::put('/update/{commoditie}', [ConfigController::class, 'update'])->name('update');
        Route::delete('/delete', [ConfigController::class, 'delete'])->name('destroy');
        Route::get('/update/status/{commoditie_id}/{active}', [ConfigController::class, 'updateStatus'])->name('status');
        Route::get('export/', [ConfigController::class, 'export'])->name('export');
    });

    Route::get('/update/status/{bulletin}/{status}', [BulletinController::class, 'updateStatus'])->name('bulletins.status');
    Route::resource('bulletins', BulletinController::class);
});

/*Route::group(['middleware' => ['role:salesman']], function () {
    Route::middleware('auth')->prefix('dispatch')->name('dispatch.')->group(function () {
        Route::post('/update', [DispatchController::class, 'update'])->name('update');
        Route::post('/store', [DispatchController::class, 'store'])->name('store');
        Route::post('/bulkedit', [DispatchController::class, 'bulkedit'])->name('bulkedit');
    });
});*/

Route::group(['middleware' => ['role:salesman|truck|Admin']], function () {


    /*Route::middleware('auth')->prefix('dispatch')->name('dispatch.')->group(function () {

        Route::get('/searchview', [DispatchController::class, 'searchview'])->name('searchview');


        Route::get('/', [DispatchController::class, 'index'])->name('index');
        Route::get('/create', [DispatchController::class, 'create'])->name('create');
        Route::post('/store', [DispatchController::class, 'store'])->name('store');
       // Route::get('/edit/{dispatch}', [DispatchController::class, 'edit'])->name('edit');
        Route::post('/update', [DispatchController::class, 'update'])->name('update');
        Route::post('/bulkedit', [DispatchController::class, 'bulkedit'])->name('bulkedit');
       // Route::delete('/delete', [DispatchController::class, 'delete'])->name('destroy');
       // Route::get('/update/status/{dispatch_id}/{status}', [DispatchController::class, 'updateStatus'])->name('status');


       // Route::get('/import-users', [DispatchController::class, 'importUsers'])->name('import');
       // Route::post('/upload-users', [DispatchController::class, 'uploadUsers'])->name('upload');

       // Route::get('export/', [DispatchController::class, 'export'])->name('export');

       Route::get('/update/delivered/{id}/{delivered}', [DispatchController::class, 'updatedelivered'])->name('updatedelivered');
       Route::get('/update/noship/{id}/{noship}', [DispatchController::class, 'updatenoship'])->name('updatenoship');


        /////////////Ajax Routes

        Route::post('/getCommoditieSuppliers', [DispatchController::class, 'getCommoditieSuppliers'])->name('getCommoditieSuppliers');
        Route::post('/getSuppliersExits', [DispatchController::class, 'getSuppliersExits'])->name('getSuppliersExits');
        Route::post('/getdispatch', [DispatchController::class, 'getdispatch'])->name('getdispatch');

        Route::match(['get', 'post'],'/searchresult', [DispatchController::class, 'searchresult'])->name('searchresult');
    });*/
    Route::middleware('auth')->prefix('dispatch')->name('dispatch.')->group(function () {

        Route::get('/searchview', [DispatchController::class, 'searchview'])->name('searchview');

        Route::get('/', [DispatchController::class, 'index'])->name('index');
        Route::get('/create', [DispatchController::class, 'create'])->name('create');
        Route::post('/store', [DispatchController::class, 'store'])->name('store');
        Route::get('/edit/{dispatch}', [DispatchController::class, 'edit'])->name('edit');
        Route::post('/update', [DispatchController::class, 'update'])->name('update');
        Route::post('/bulkedit', [DispatchController::class, 'bulkedit'])->name('bulkedit');
        Route::delete('/delete', [DispatchController::class, 'delete'])->name('destroy');
        Route::get('/update/status/{dispatch_id}/{status}', [DispatchController::class, 'updateStatus'])->name('status');

        Route::get('/update/delivered/{id}/{delivered}', [DispatchController::class, 'updatedelivered'])->name('updatedelivered');
        Route::get('/update/noship/{id}/{noship}', [DispatchController::class, 'updatenoship'])->name('updatenoship');

        Route::get('/import-users', [DispatchController::class, 'importUsers'])->name('import');
        Route::post('/upload-users', [DispatchController::class, 'uploadUsers'])->name('upload');

        Route::get('export/', [DispatchController::class, 'export'])->name('export');


        /////////////Ajax Routes

        Route::post('/getCommoditieSuppliers', [DispatchController::class, 'getCommoditieSuppliers'])->name('getCommoditieSuppliers');
        Route::post('/getSuppliersExits', [DispatchController::class, 'getSuppliersExits'])->name('getSuppliersExits');
        Route::post('/getdispatch', [DispatchController::class, 'getdispatch'])->name('getdispatch');
        Route::post('/changelog', [DispatchController::class, 'changelog'])->name('changelog');
        Route::post('/changedisplay', [DispatchController::class, 'changedisplay'])->name('changedisplay');
        Route::post('/GetReleaseCode', [DispatchController::class, 'GetReleaseCode'])->name('GetReleaseCode');

        Route::post('/RealseCodeVefiry', [DispatchController::class, 'RealseCodeVefiry'])->name('RealseCodeVefiry');
        Route::match(['get', 'post'], '/searchresult', [DispatchController::class, 'searchresult'])->name('searchresult');
    });
});

/*Route::group(['middleware' => ['role:salesman|admin']], function () {
    Route::middleware('auth')->prefix('dispatch')->name('dispatch.')->group(function () {
        Route::post('/update', [DispatchController::class, 'update'])->name('update');
        Route::post('/store', [DispatchController::class, 'store'])->name('store');
        Route::post('/bulkedit', [DispatchController::class, 'bulkedit'])->name('bulkedit');
    });
});*/
