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

// Show create Form
Route::get('/listings/create', [ListingController::class, 'create']);

//Store listing data
Route::post('/listings', [ListingController::class, 'store']);

// Show edit form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit']);

//update listing
Route::put('/listings/{listing}', [ListingController::class, 'update']);

//delete listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy']);

//Single Listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

// Show register form/create form
Route::get('/register', [UserController::class, 'create']);

// create new user
Route::post('/users', [UserController::class, 'store']);

// user logout
Route::post('/logout', [UserController::class, 'logout']);

// show login form
Route::get('/login', [UserController::class, 'login']);

// login user
Route::post('/users/authenticate', [UserController::class, 'authenticate']);
