<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\testcontroller;
use App\Models\t_test;
use App\Models\dog;
use App\Models\t;
use App\Models\MongoModel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;

Route::get('/{model}', function(Request $request){
  $Model = "App\Models\\".$request->model;
  $data = $Model::where('name','like',"%". $request->query('_name') ."%")->limit($request->query('_limit'))->orderByDesc('_id');
  if($request->query('_age')) {$data = $data->where('age', $request->query('_age'));}
  return(json_encode($data->get()));
});

Route::post('/', function(Request $request){
  $photoName = $request->attributes->get('photoName');
  $data = 'App\\Models\\MongoModel'::create(['name'=>$request->input('name'), 'age'=>$request->input('age'), 'photo'=>$photoName]);
  return (json_encode(["newId"=>$data->_id, "photo"=>$photoName]));
})->middleware('PhotoConfirm');

Route::post('/s', function(Request $request){
  $photoName = $request->attributes->get('photoName');
  $data = t::create(['name'=>$request->input('name'), 'age'=>$request->input('age'), 'photo'=>$photoName]);
  return (json_encode(["newId"=>$data->id, "photo"=>$photoName]));
})->middleware('PhotoConfirm');

Route::put('/{id}', function(Request $request){
  $photoName = $request->attributes->get('photoName');
  'App\\Models\\MongoModel'::find($request->id)->update(['name'=>$request->input('name'), 'age'=>$request->input('age'), 'photo'=>$photoName]);
  return (json_encode(["photo"=>$photoName]));
})->middleware('PhotoConfirm');

Route::put('/s/{id}', function(Request $request){
  $photoName = $request->attributes->get('photoName');
  t::find($request->id)->update(['name'=>$request->input('name'), 'age'=>$request->input('age'), 'photo'=>$photoName]);
  return (json_encode(["photo"=>$photoName]));
})->middleware('PhotoConfirm');

Route::delete('/{id}', function(Request $request){
  DB::connection('test')->table('users')->where('id', $request->id)->delete();
    //GET the replacement row
    $q = "SELECT * FROM users WHERE id=(SELECT Max(id) from users where id < '". $request->query('lasttableid') ."')";
    $row = DB::connection('test')->select($q);
    return(json_encode($row));
});





Route::get('/add', function(Request $request){
  return view('view1');
});
