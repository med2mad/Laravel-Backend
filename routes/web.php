<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\Mysql;
use Illuminate\Http\Request;
use App\Http\Requests\request2;


Route::get('/{model}', function(Request $request){
  $Model = "App\Models\\".$request->model;
  $data = $Model::select('_id','name','age','photo')->where('name','like',"%". $request->query('name') ."%")->offset(($request->query('page')-1)*$request->query('limit'))->limit($request->query('limit'))->orderByDesc('_id');
  $count = $Model::select('_id')->where('name','like',"%". $request->query('name') ."%");
  if($request->query('age')) {$data = $data->where('age', $request->query('age')); $count = $data->where('age', $request->query('age'));}
  return(json_encode(["rows"=>$data->get(), "total"=>$count->count()]));
});


Route::post('/{model}', function(Request $request){
  try{
    $request->validate(['name'=>'between:1,30', 'age'=>'integer|min:18|max:99']);
  } catch (\Illuminate\Validation\ValidationException $th) {
    $errors = [];
    if(isset($th->errors()["name"])){array_push($errors, ["path"=>"name"]);} //"path" to match express-validator
    if(isset($th->errors()["age"])){array_push($errors, ["path"=>"age"]);}
    return(["errors"=>$errors]);
  }
  $photoName = $request->attributes->get('photoName');
  $Model = "App\Models\\".$request->model;
  $data = $Model::create(['name'=>$request->input('name'), 'age'=>$request->input('age'), 'photo'=>$photoName]);
  return (json_encode(["newId"=>$data->_id, "photo"=>$photoName]));  
})->middleware('PhotoConfirm');


Route::put('/{model}/{id}', function(Request $request){
  try {
    $request->validate(['name'=>'between:1,30', 'age'=>'integer|min:18|max:99']);
  } catch (\Illuminate\Validation\ValidationException $th) {
    $errors = [];
    if(isset($th->errors()["name"])){array_push($errors, ["path"=>"name"]);}
    if(isset($th->errors()["age"])){array_push($errors, ["path"=>"age"]);}
    return(["errors"=>$errors]);
  }
  $photoName = $request->attributes->get('photoName');
  $Model = "App\Models\\".$request->model;
  $Model::find($request->id)->update(['name'=>$request->input('name'), 'age'=>$request->input('age'), 'photo'=>$photoName]);
  return (json_encode(["editedId"=>$request->id, "photo"=>$photoName]));
})->middleware('PhotoConfirm');


Route::delete('/{model}/{id}', function(Request $request){
  $Model = "App\Models\\".$request->model;
  $Model::find($request->id)->delete();
    //GET the replacement row
    $max = $Model::select('_id')->where('_id','<',$request->query('lasttableid'))->max('_id');
    $data = $Model::select('_id','name','age','photo')->where('_id', $max);
    return(json_encode(["rows"=>$data->get(), "deletedId"=>$request->id]));
});





Route::get('/add/add', function(Request $request){
  return view('viewf');
  // return view('viewt', ['items'=>MysqlModel::paginate(10)]);
});
