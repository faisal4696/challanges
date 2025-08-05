<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();

        DB::table('users')->insert(
                [
                    [
                'name' => 'Muhammad Faisal',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('12345'),
                'role' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                    ],[
                    'name' => 'Umer',
	                'email' => 'umer@gmail.com',
	                'password' => bcrypt('12345'),
	                'role' => '0',
	                'created_at' => Carbon::now(),
	                'updated_at' => Carbon::now(),
                ],[
                    'name' => 'Hammad',
	                'email' => 'hammad@gmail.com',
	                'password' => bcrypt('12345'),
	                'role' => '0',
	                'created_at' => Carbon::now(),
	                'updated_at' => Carbon::now(),
                ],[
                    'name' => 'Shams',
	                'email' => 'shams@gmail.com',
	                'password' => bcrypt('12345'),
	                'role' => '0',
	                'created_at' => Carbon::now(),
	                'updated_at' => Carbon::now(),
                ],[
                	'name' => 'Hassan',
	                'email' => 'hassan@gmail.com',
	                'password' => bcrypt('12345'),
	                'role' => '0',
	                'created_at' => Carbon::now(),
	                'updated_at' => Carbon::now(),
                ]
            ]
            );
        Schema::enableForeignKeyConstraints();
    }
}
