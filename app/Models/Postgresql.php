<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Postgresql extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $connection= 'pgsql';
    // protected $connection= 'pgsql elephantsql.com';
    protected $table = 'profiles';
    public $timestamps = false;
    protected $primaryKey = '_id'; //whithout this, the primarykey is 'id', and POST requests return 'id' and i want '_id'
                                    //in raw sql it is already handled by the 'RETURNING' clause of the 'INSERT' query 
}