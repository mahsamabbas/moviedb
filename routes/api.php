<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;


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

// Api route (for fetching movies from TMDB API)
Route::get('getMovies', [MovieController::class, 'store']);

