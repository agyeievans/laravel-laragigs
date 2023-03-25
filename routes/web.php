<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Listing;
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

// All listings
Route::get('/', [ListingController::class, 'index']);

// Show create Form and added authenticated user should only see the create listing
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

//Store listing data
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

// Show edit form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

//update listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

//delete listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy']);

// manage listings
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

//Single Listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

// Show register form/create form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// create new user
Route::post('/users', [UserController::class, 'store']);

// user logout
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// show login form and added name to the route
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// login user
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

