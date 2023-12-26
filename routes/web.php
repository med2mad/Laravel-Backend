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

  // $q = "SELECT * FROM users WHERE name LIKE '%". $req->query('_name') ."%'";
  // if ($req->query('_age')) {$q .= " AND age = '". $req->query('_age') ."'";}
  // $q.= " ORDER BY id DESC LIMIT ". $req->query('_limit');
  // return(json_encode(DB::connection('test')->select($q)));

  // $data = DB::connection('test')->table('users')->where('name','like',"%". $req->query('_name') ."%")->limit($req->query('_limit'))->orderBy('id', 'desc');
  // if($req->query('_age')) {$data = $data->where('age', $req->query('_age'));}
  // return(json_encode($data->get()));

  $data = t::where('name','like',"%". $req->query('_name') ."%")->limit($req->query('_limit'))->orderByDesc('id');
  if($req->query('_age')) {$data = $data->where('age', $req->query('_age'));}
  return(json_encode($data->get()));
});
Route::post('/', function(Request $req){
  $data = t::create(['name'=>$req->input('name'), 'age'=>$req->input('age'), 'photo'=>'']);
  return (json_encode(["newId"=>$data->id, "photo"=>'']));
});
 
Route::get('/add', function(Request $req){
  return view('view1');
});
