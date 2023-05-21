<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Auth;

Route::group(['middleware'=>'guest'],function(){
    Route::get('/login',[UserController::class,'loginPage']);
    Route::get('/register',[UserController::class,'registerPage']);
});

Route::group(['middleware'=>'admin'],function(){
    Route::get('/insert-genre',[GenreController::class,'displayGenre']);
    Route::get('/genre-detail/{id}',[GenreController::class,'showGenreDetail']);
    Route::get('/manage-book',[BookController::class,'showBooks']);
    Route::get('/manage-user',[UserController::class,'displayUser']);
    Route::get('/user-detail/{id}',[UserController::class,'userDetail']);
});

Route::group(['middleware'=>'member'],function(){
    Route::get('/cart',[BookController::class,'cart']);
    Route::get('/checkout-cart',[BookController::class,'checkout']);
    Route::get('/transaction-history',[UserController::class,'transactionHistory']);
    Route::get('/transaction-detail/{id}',[UserController::class,'transactionDetail']);
});

Route::get('/profile-page',[UserController::class,'profilePage'])->middleware('loggedin');
Route::get('/change-password',[PasswordController::class,'view'])->middleware('loggedin');
Route::delete('/delete-user/{id}',[UserController::class,'deleteUser']);
Route::post('/login',[UserController::class,'login']);
Route::get('/logout',[UserController::class,'logout']);
Route::post('/register',[UserController::class,'register']);
Route::put('/update-profile/{id}',[UserController::class,'updateProfile']);
Route::put('/updateUserDetail/{id}',[UserController::class,'updateUserDetail']);



Route::post('/insert-genre',[GenreController::class,'insertGenre']);
Route::put('/update-genre/{id}',[GenreController::class,'updateGenre']);
Route::delete('/delete-genre/{id}',[GenreController::class,'deleteGenre']);

Route::put('/update-book/{id}',[BookController::class,'updateBook']);
Route::get('/book-detail/{id}/{qty}/{id2}',[BookController::class,'showBookEditDetail']);
Route::get('/book-detail/{id}',[BookController::class,'showBookDetail']);
Route::post('/manage-book',[BookController::class,'insertBook']);
Route::delete('/delete-book/{id}',[BookController::class,'deleteBook']);
Route::get('/',[BookController::class,'booksHome']);
Route::get('/search',[BookController::class,'search']);
Route::get('/aboutus',[BookController::class,'showAbout']);
Route::get('/cart/{book}',[BookController::class,'addtoCart']);
Route::get('/edit-cart/{id}',[BookController::class,'editCart']);
Route::delete('/delete-cart/{id}',[BookController::class,'deleteCart']);

Route::post('/change-password',[PasswordController::class,'changePass']);

Route::get('session/get',[BookController::class,'accessSessionData']);
