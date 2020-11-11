<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
    return view('welcome');
});

Route::get('/access_file', function () {
    return view('test_file');
});

Route::post('/upload', function(Request $request){

    if($request->audiovideo){
        $file = $request->audiovideo;
        $name = Str::random(10);
        $fname=$name.".".$file->extension();
        $file->storeAs('public/videos/', $fname);

        return response()->json(["status"=>$fname]);
    }

    return response()->json(["file_info+ "=>$request->audiovideo]);

})->name("upload");
