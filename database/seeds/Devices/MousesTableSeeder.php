<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MousesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mouses')->truncate();

        $now = Carbon::now();
        DB::table('mouses')->insert([
            [
                'mouse_name' => 'RIVAL 600',
                'maker_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'mouse_name' => 'G304',
                'maker_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'mouse_name' => 'ZA 13',
                'maker_id' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'mouse_name' => 'DeathAdder V2',
                'maker_id' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'mouse_name' => 'ROG Gradius Ⅱ',
                'maker_id' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}