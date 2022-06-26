<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TweetController;
use App\Models\Tweet;

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
    $tweets = Tweet::latest()->take(5)->get();
    return view('home',compact('tweets'));
})->name('home');
Route::get('/verify', function () {
    return view('verify');
})->name('verify-form');

Route::post('/tweet', [TweetController::class, 'verifyTweet'])->name('verify');
Route::get('/verified-tweet/{id}', [TweetController::class, 'viewTweet'])->name('tweet.detail');