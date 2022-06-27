<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TweetController;
use App\Models\Tweet;
use App\Models\Hashtag;
use App\Models\TwitterUser;
use Illuminate\Http\Request;


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

Route::get('/hashtags', function (Request $request) {
    if(request()->filled('search')){
        $hashtags= Hashtag::where('word', 'like', '%' . $request->query('search') . '%')->take(50)->OrderBy('created_at','desc')->get();
    }else{
        $hashtags=  Hashtag::latest()->take(50)->get();
    }

    return view('hashtags',compact('hashtags'));
})->name('hashtags');

Route::get('/hashtag/{id}', function ($id) {
    $hashtag=Hashtag::findOrFail($id);
    $tweets=$hashtag->tweets()->OrderBy('created_at','desc')->paginate(5);
    return view('hashtag-detail',compact('hashtag','tweets'));
})->name('hashtag');

Route::get('/users', function (Request $request) {
    if(request()->filled('search')){
        $users= TwitterUser::where('name', 'like', '%' . $request->query('search') . '%')->orWhere('username', 'like', '%' . $request->query('search') . '%')->take(50)->OrderBy('created_at','desc')->paginate(12);
    }else{
        $users=  TwitterUser::latest()->take(50)->paginate(12);
    }
    return view('users',compact('users'));
})->name('users');

Route::get('/user/{id}', function ($id) {
    $user=TwitterUser::findOrFail($id);
    $tweets=$user->tweets()->OrderBy('created_at','desc')->paginate(5);
    return view('user-detail',compact('user','tweets'));
})->name('user');


Route::post('/tweet', [TweetController::class, 'verifyTweet'])->name('verify');
Route::get('/verified-tweet/{id}', [TweetController::class, 'viewTweet'])->name('tweet.detail');