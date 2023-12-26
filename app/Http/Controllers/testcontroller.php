<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Http\Request;

class testcontroller extends Controller
{
    function __invoke(){
        return view('view1');
    }
}
