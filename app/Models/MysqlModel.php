<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class MysqlModel extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'test.users';
    protected $primaryKey = '_id';//whithout this, the primarykey is 'id', and POST requests return 'id' and i want '_id'
                                    //no problem in raw sql, cause it already returns the table's primarykey
    // protected $connection = 'test';
}
