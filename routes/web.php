<?php

use App\Http\Controllers\tables;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [tables::class, 'GetTables']);
Route::get('/getTable', [tables::class, 'GetTable']);
Route::post('/create-order', [\App\Http\Controllers\orders::class, 'CreateOrder']);


// Admin Routes

Route::get('/getTables', [tables::class, 'GetTablesForAdmin']);
Route::get('/create-table-view', function (){
    return view ('create-table');
});
Route::get('/edit-table-view', [tables::class, 'GetTableView']);
Route::post('/create-table', [tables::class, 'CreateTable']);
Route::put('/update-table', [tables::class, 'UpdateTable']);
Route::delete('/delete-table', [tables::class, 'DeleteTable']);

Route::get('/getOrders', [\App\Http\Controllers\orders::class, 'GetOrders']);
Route::put('/update-order', [\App\Http\Controllers\orders::class, 'UpdateOrder']);
Route::delete('/delete-order', [\App\Http\Controllers\orders::class, 'DeleteOrder']);
