<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Mongoodb extends Model
{
    use HasFactory;

    protected $guarded = [];
    // protected $connection= 'mongodb';
    protected $connection= 'mongodb cloud.mongodb.com';
    protected $collection = 'profiles';

}