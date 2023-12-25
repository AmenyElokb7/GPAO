<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\projects;


Route::get('/main', function () {
    return view('welcome');
})->name("main");

Auth::routes();

Route::get('/home', [App\Http\Controllers\pagesController::class, 'index'])->name('home');
Route::get('/users', [App\Http\Controllers\pagesController::class, 'users'])->name('users');
Route::get('/suppliers', [App\Http\Controllers\pagesController::class, 'suppliers'])->name('suppliers');
Route::get('/posts', [App\Http\Controllers\pagesController::class, 'posts'])->name('posts');
Route::get('/units', [App\Http\Controllers\pagesController::class, 'units'])->name('units');
Route::get('/search', [App\Http\Controllers\pagesController::class, 'search'])->name('search');
Route::get('/projects', [App\Http\Controllers\pagesController::class, 'projectSearch']);


Route::get('/', [App\Http\Controllers\pagesController::class, 'projects'])->name('projects');
Route::get('/new', [App\Http\Controllers\pagesController::class, 'new'])->name('projects.new');
Route::get('/products', [App\Http\Controllers\pagesController::class, 'products'])->name('products');
Route::get('/tasks', [App\Http\Controllers\pagesController::class, 'getTasks'])->name('tasks');

Route::post("/addUser", [App\Http\Controllers\adminController::class, 'addUser']);
Route::get("/CHECK", [App\Http\Controllers\adminController::class, 'VerifierExistance']);
Route::delete('/deleteUser/{id}', [App\Http\Controllers\adminController::class, 'deleteUser']);
Route::post('/editUser', [App\Http\Controllers\adminController::class, 'editUser']);

Route::post("/addProject", [App\Http\Controllers\adminController::class, 'addProject']);
Route::post('/editProject', [App\Http\Controllers\adminController::class, 'editProject']);
Route::get('/{id}', [App\Http\Controllers\adminController::class, 'show'])->name('projects.show');
Route::delete("/deleteProject/{id}", [App\Http\Controllers\adminController::class, 'deleteProject']);



Route::post("/addProduct", [App\Http\Controllers\adminController::class, 'addProduct'])->name('addProduct');
Route::delete("/deleteProduct/{id}", [App\Http\Controllers\adminController::class, 'deleteProduct']);
Route::get('getProductImage/{id}', [App\Http\Controllers\adminController::class, 'getProductImage'])->name('getProductImage');
Route::get('/check-stock/{productId}/{quantity}', [App\Http\Controllers\adminController::class, 'checkStock'])->name('checkStock');
Route::post('/addProject', [App\Http\Controllers\adminController::class, 'addProject'])->name('addProject');

Route::get('/CompleteP/{id}', [App\Http\Controllers\adminController::class, 'CompleteP'])->name('CompleteP');

Route::post('/addPost', [App\Http\Controllers\adminController::class, 'addPost']);
Route::delete("/deletePost/{id}", [App\Http\Controllers\adminController::class, 'deletePost']);

Route::post("/addunit", [App\Http\Controllers\adminController::class, 'addunit']);
Route::delete("/deleteunit/{id}", [App\Http\Controllers\adminController::class, 'deleteunit']);

Route::post("/addTask", [App\Http\Controllers\adminController::class, 'addTask']);
Route::post('/editTask', [App\Http\Controllers\adminController::class, 'editTask']);
Route::delete("/deleteTask/{id}", [App\Http\Controllers\adminController::class, 'deleteTask']);



Route::post('/search-results', [App\Http\Controllers\adminController::class, 'searchProjects']);


