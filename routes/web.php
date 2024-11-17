<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");


use Illuminate\Support\Facades\Route;
use App\Models\Mysql;
use App\Models\Postgresql;
use App\Models\Mongodb;
use Illuminate\Http\Request;

Route::get('/{model}', function(Request $request){
  $Model = "App\Models\\".$request->model;
  $data = $Model::select('_id','name','age','photo')->offset(($request->query('page')-1)*$request->query('limit'))->limit($request->query('limit'))->orderByDesc('_id');
  $count = $Model::select('_id');
  if($request->query('name')) {
    $data = $data->where('name','like', $request->query('name'));
    $count = $count->where('name','like', $request->query('name'));
  }
  if($request->query('age')) {$data = $data->where('age', $request->query('age')); $count = $count->where('age', $request->query('age'));}
  return (["rows"=>$data->get(), "total"=>$count->count(), "rawSQL"=>$data->toSql()]);
});


Route::post('/{model}', function(Request $request){
  try{
    $request->validate(['name'=>'between:1,30', 'age'=>'integer|min:18|max:99']);
  } catch (\Illuminate\Validation\ValidationException $th) {
    $errors = [];
    if(isset($th->errors()["name"])){array_push($errors, ["path"=>"name"]);} //"path" to match express-validator
    if(isset($th->errors()["age"])){array_push($errors, ["path"=>"age"]);}
    return (["errors"=>$errors]);
  }
  $photoName = $request->attributes->get('photoName');
  $Model = "App\Models\\".$request->model;
  $data = $Model::create(['name'=>$request->input('name'), 'age'=>$request->input('age'), 'photo'=>$photoName]);
  return (["newId"=>$data->_id, "photo"=>$photoName, "rawSQL"=>"INSERT INTO profiles (name, age, photo) VALUES ('".$request->input('name')."', ".$request->input('age').", '".str_replace("%20", " ", $photoName)."');"]);
})->middleware('PhotoConfirm');


Route::put('/{model}/{id}', function(Request $request){
  try {
    $request->validate(['name'=>'between:1,30', 'age'=>'integer|min:18|max:99']);
  } catch (\Illuminate\Validation\ValidationException $th) {
    $errors = [];
    if(isset($th->errors()["name"])){array_push($errors, ["path"=>"name"]);}
    if(isset($th->errors()["age"])){array_push($errors, ["path"=>"age"]);}
    return (["errors"=>$errors]);
  }
  $photoName = $request->attributes->get('photoName');
  $Model = "App\Models\\".$request->model;
  $Model::find($request->id)->update(['name'=>$request->input('name'), 'age'=>$request->input('age'), 'photo'=>$photoName]);
  return (["editedId"=>$request->id, "photo"=>$photoName, "rawSQL"=>"UPDATE profiles SET name='".$request->input('name')."', age=".$request->input('age').", photo='".str_replace("%20", " ", $photoName)."' WHERE id=".$request->id.";"]);
})->middleware('PhotoConfirm');


Route::delete('/{model}/{id}', function(Request $request){
  $Model = "App\Models\\".$request->model;
  $Model::find($request->id)->delete();
    //GET the replacement row
    $max = $Model::select('_id')->where('_id','<',$request->query('lasttableid'))->max('_id');
    $data = $Model::select('_id','name','age','photo')->where('_id', $max);
    return ((["rows"=>$data->get(), "deletedId"=>$request->id, "rawSQL"=>"DELETE FROM profiles WHERE id=".$request->id.";"]));
});




Route::get('/add/add', function(Request $request){
  return view('viewf');
  // return view('viewt', ['items'=>MysqlModel::paginate(10)]);
});
