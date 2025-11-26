<?php

use App\Http\Controllers\AboutContentController;
use App\Http\Controllers\AdmissionsContentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvisosController;
use App\Http\Controllers\DepartamentosController;
use App\Http\Controllers\EventosController;
use App\Http\Controllers\EventoViewController;
use App\Http\Controllers\HomeContentController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MonthlyViewsController;
use App\Http\Controllers\NewsController;
use App\Models\Avisos;
use App\Models\Eventos;
use App\Models\MonthlyViews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('addUser', [AuthController::class, 'addUser']);
    Route::post('updateUser/{field}/{id}', [AuthController::class, 'updateUser']);


});
Route::group([
    'middleware' => 'api',

], function($router) {
    Route::get(('users'), [AuthController::class, 'getAllUsers']);
    Route::post(('deleteUser/{id}'), [AuthController::class, 'deleteUser']);
    Route::get(('homeContents'), [HomeContentController::class, 'all']);
    Route::post(('editHomeContent/{field}/{id}'), [HomeContentController::class, 'update']);
    Route::get(('aboutContents'), [AboutContentController::class, 'all']);
    Route::post(('editAboutContent/{field}/{id}'), [AboutContentController::class, 'update']);
    Route::get(('departamentos'), [DepartamentosController::class, 'all']);
    Route::post(('editDepartment/{field}/{id}'), [DepartamentosController::class, 'update']);
    Route::get(('department/{id}'), [DepartamentosController::class, 'get']);
    Route::get(('events'), [EventosController::class, 'all']);
    Route::post(('addEvent'), [EventosController::class, 'addEvent']);
    Route::post(('editEvent/{id}'), [EventosController::class, 'update']);
    Route::post(('deleteEvent/{id}'), [EventosController::class, 'delete']);


    Route::get(('admissionsContents'), [AdmissionsContentController::class, 'all']);
    Route::post(('editAdmissionsContent/{field}/{id}'), [AdmissionsContentController::class, 'update']);


    Route::get(('news'), [NewsController::class, 'all']);
    Route::get(('news/{id}'), [NewsController::class, 'get']);
    Route::post(('addNews'), [NewsController::class, 'addNews']);
    Route::post(('editNews/{field}/{id}'), [NewsController::class, 'update']);
    Route::post(('deleteNews/{id}'), [NewsController::class, 'delete']);


    Route::get(('info'), [InfoController::class, 'all']);
    Route::post(('editInfo/{id}'), [InfoController::class, 'update']);
    Route::post('/send-email', [MailController::class, 'sendEmail']);
    Route::post('/handleChat', [MailController::class, 'handleChat']);
    Route::get('/eventosViews', [EventoViewController::class, 'all']);Route::post('/addEventoView', [EventoViewController::class, 'store']);
    Route::get('/monthlyViews', [MonthlyViewsController::class, 'all']);
    Route::post('/addMonthlyView', [MonthlyViewsController::class, 'store']);
    Route::get('/monthlyViews1', [MonthlyViewsController::class, 'all1']);
    Route::post('/addMonthlyView1', [MonthlyViewsController::class, 'store1']);

    Route::get(('avisos'), [AvisosController::class, 'all']);
    Route::post('/addAviso', [AvisosController::class, 'addAviso']);    Route::post(('editAviso/{id}'), [AvisosController::class, 'update']);
















});
