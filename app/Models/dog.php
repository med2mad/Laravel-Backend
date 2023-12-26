<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class dog extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'name'
    // ];
    // protected $guarded = [
    // ];

    // protected function name(): Attribute{
    //     return Attribute::make(
    //         set: fn($value)=>Str::lower($value), //manipulate value send to the DataBase using the Model
    //         get: fn($value)=>Str::ucfirst($value) //manipulate value got (works with "Model::find(1)->column")
    //     );
    // }
    
}
