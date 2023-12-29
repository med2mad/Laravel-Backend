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

    
}
