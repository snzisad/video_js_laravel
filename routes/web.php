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
    dd($request->audiovideo);

    if($request->hasFile('audiovideo')){
        $file = $request->file('audiovideo');
        $name = Str::random(10);
        $fname=$name.".".$file->getClientOriginalExtension();
        $file->storeAs('public/videos/', $fname);

        return response()->json(["status"=>true]);
    }

    return response()->json(["has_file"=>$request->audiovideo]);

})->name("upload");
