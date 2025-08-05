<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ConversationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('conversations')->truncate();

        DB::table('conversations')->insert(
                [
                    [
                'sender_id' => '1',
                'receiver_id' => '2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                    ],[
                    'sender_id' => '3',
	                'receiver_id' => '4',
	                'created_at' => Carbon::now(),
	                'updated_at' => Carbon::now(),
                ]
            ]
            );
        Schema::enableForeignKeyConstraints();
    }
}
