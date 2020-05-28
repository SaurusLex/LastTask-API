<?php

use Illuminate\Support\Facades\Route;
use App\Mail\WelcomeMail;

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

Route::get("/projects/{id}", function ($id) {

});

/*
||                                                              ||
||                          Real project                        ||
||                                                              ||
 */



Route::group(['middleware' => 'auth:api'], function () {

    /*
     *********************************[Projects]*********************************
     */
    Route::get("/projects", "ProjectController@getAll");
    Route::get("/projects/{id}", "ProjectController@getById");
    Route::get("/projects/user/{id}", "ProjectController@getByUserId");
    Route::post("/projects", "ProjectController@create");
    Route::delete("/projects/{id}", "ProjectController@deleteById");
    Route::put("/projects", "ProjectController@update");
    Route::get("/projects/{id}/fbudget", "ProjectController@finalBudget");
    Route::get("/projects/{id}/ebudget", "ProjectController@estimatedBudget");

    /*
    *********************************[Users]************************************
    */

    Route::get("/session", "UserController@getsessiondata");
    Route::delete('users/{id}', "UserController@delete");
    Route::get('auth/logout/{id}', "UserController@logout");

    /*
    *********************************[Tasks]************************************
    */
    Route::get("/projects/{id}/tasks/", "TaskController@getAllByProjectId");
    Route::get("/tasks/{id}", "TaskController@getOneById");
    Route::delete("/tasks/{id}", "TaskController@deleteOne");
    Route::put("/tasks", "TaskController@update");
    Route::post("/tasks", "TaskController@create");

    /*
    *********************************[Clients]************************************
    */
    Route::post("/clients","ClientController@create");
    Route::get("/clients","ClientController@getAll");
});
Route::post("/register", "UserController@register");
Route::post("/auth","UserController@auth");


