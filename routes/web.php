<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\testcontroller;
use App\Models\t_test;
use App\Models\PostgreSQLModel;
use App\Models\MysqlModel;
use App\Models\MongoModel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;

Route::get('/{model}', function(Request $request){
  $Model = "App\Models\\".$request->model;
  $data = $Model::where('name','like',"%". $request->query('_name') ."%")->limit($request->query('_limit'))->orderByDesc('_id');
  if($request->query('_age')) {$data = $data->where('age', $request->query('_age'));}
  return(json_encode($data->get()));
});

Route::post('/{model}', function(Request $request){
  $photoName = $request->attributes->get('photoName');
  $Model = "App\Models\\".$request->model;
  $data = $Model::create(['name'=>$request->input('name'), 'age'=>$request->input('age'), 'photo'=>$photoName]);
  return (json_encode(["newId"=>$data->_id, "photo"=>$photoName]));  
})->middleware('PhotoConfirm');

Route::put('/{model}/{id}', function(Request $request){
  $photoName = $request->attributes->get('photoName');
  $Model = "App\Models\\".$request->model;
  $Model::find($request->id)->update(['name'=>$request->input('name'), 'age'=>$request->input('age'), 'photo'=>$photoName]);
  return (json_encode(["photo"=>$photoName]));
})->middleware('PhotoConfirm');

Route::delete('/{model}/{id}', function(Request $request){
  $Model = "App\Models\\".$request->model;
  $Model::find($request->id)->delete();
    //GET the replacement row
    $max = $Model::where('_id','<',$request->query('lasttableid'))->max('_id');
    $data = $Model::where('_id', $max);
    return(json_encode($data->get()));
});





Route::get('/add/add', function(Request $request){
  return view('viewf');
  return view('viewt', ['items'=>MysqlModel::paginate(10)]);
  
});
