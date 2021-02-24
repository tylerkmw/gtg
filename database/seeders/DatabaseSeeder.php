<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Tyler',
            'email' => 'tylerkmw@gmail.com',
            'password' => Hash::make('test'),
        ]);


        DB::table('exercises')->insert([
            'name' => 'Push-Ups',
            'reps_in_set' => 5,
            'created_at' => new \DateTime()
        ]);


        DB::table('sets')->insert([
            'exercise_id' => 1,
            'reps' => 5,
            'created_at' => new \DateTime()
        ]);

    }
}
