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
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;

Route::get('/', function(Request $req){
  $data = t::where('name','like',"%". $req->query('_name') ."%")->limit($req->query('_limit'))->orderByDesc('id');
  if($req->query('_age')) {$data = $data->where('age', $req->query('_age'));}
  return(json_encode($data->get()));
});
Route::post('/', function(Request $req){
  echo $req->file('photo')->getClientOriginalName(); echo '<br/>';
  echo $req->file('photo')->getMimeType(); echo '<br/>';
  echo $req->file('photo')->getSize(); echo '<br/>';
  echo $req->file('photo')->store('C:/Users/MED/Desktop/',$req->file('photo')->getClientOriginalName());
exit();
  $data = t::create(['name'=>$req->input('name'), 'age'=>$req->input('age'), 'photo'=>'']);
  return (json_encode(["newId"=>$data->id, "photo"=>'']));
});
Route::put('/{id}', function(Request $req){
  dd($req->file('photo'));
  t::find($req->id)->update(['name'=>$req->input('name'), 'age'=>$req->input('age'), 'photo'=>'']);
  return (json_encode(["photo"=>'']));
});

Route::get('/add', function(Request $req){
  return view('view1');
});
