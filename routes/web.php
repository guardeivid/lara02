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

//Middlewares
//php artisan make:middleware CheckAge
//En app/Http/Middleware/CheckAge.php  la funcion handle() maneja la solicitud
//middleware hay que registrarlo en app/Http/Kernel.php dentro de $routeMiddleware
Route::get('/home', function(){
    return "Si ves esta pagina es porque eres mayor de edad";
})->middleware('edad');
//intecepta la solicitud, es mayor pasa sino, retorna login
//http://larticles.test/home redirige a http://larticles.test/login
//
//http://larticles.test/home?age=18 permite ver la pagina

Route::get('/login', function(){
    return "Formulario para iniciar sesion";
})->name('auth.login');

//Otra manera de hacerlo es

//php artisan make:controller UserController --resource
//Si se lo coloca en el constructor de un controlador sera llamado el middleware cada vez que se lo llama
Route::resource('/users', 'UserController');
//ver todas las rutas
//php artisan route:list
//
//http://larticles.test/users/5/edit?age=19

//Para pasar valores al middleware
//despues de CLosure, se agregan los parametros




//Formularios y validaciones
Route::get('/contacto', 'ContactController@show');
//asignar un nombre a la ruta
Route::post('/contacto', 'ContactController@store')->name('contacto.store');




Route::get('/index', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('index');
});


Route::group(['middleware' => ['web']], function () {
    Route::resource('post', 'Webartis\PostController');
    Route::POST('addPost', 'Webartis\PostController@addPost');
    Route::POST('editPost', 'Webartis\PostController@editPost');
    Route::POST('deletePost', 'Webartis\PostController@deletePost');
});

Route::get('/{any}', function () {
        return view('vueapp');
})->where('any', '.*');
