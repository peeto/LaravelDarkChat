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

use Illuminate\Support\Facades\Storage;

/* ChatController */
Route::get('chat', function() {
    $chatcontroller = new App\Http\Controllers\ChatController();
    return $chatcontroller->showChat(Storage::disk('local')->path('chatconfig.php'));
});
Route::get('chatxml', function() {
    $chatcontroller = new App\Http\Controllers\ChatController();
    return $chatcontroller->showXmlChat(Storage::disk('local')->path('chatconfig.php'));
});
Route::post('chatxml', function() {
    $chatcontroller = new App\Http\Controllers\ChatController();
    return $chatcontroller->showXmlChat(Storage::disk('local')->path('chatconfig.php'));
});
