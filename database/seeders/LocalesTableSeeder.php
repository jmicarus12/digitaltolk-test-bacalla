<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locales')->insert([
            ['code' => 'en', 'name' => 'English', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'fr', 'name' => 'French', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'es', 'name' => 'Spanish', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
