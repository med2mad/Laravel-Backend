<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MysqlModel;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // DB::insert("insert into users(name, email, password)values(?,?,?)", ['Q- '.Str::random(4), Str::random(4).'@gmail.com', Str::random(4)]);
        // DB::insert("insert into users(name, email, password)values(?,?,?)", ['Q- '.Str::random(4), Str::random(4).'@gmail.com', Str::random(4)]);
        
        DB::table('users')->insert(['name'=>'QB- '.Str::random(4), 'email'=>'nakia.little@example.org', 'password'=>Str::random(4)]);
        // DB::table('users')->insert(['name'=>'QB- '.Str::random(4), 'email'=>Str::random(4).'@gmail.com', 'password'=>Str::random(4)]);
        
        // // User::factory(1)->create();
        // // User::factory(1)->create(['name'=>'MF- '. Str::random(4)]);
    }
}
