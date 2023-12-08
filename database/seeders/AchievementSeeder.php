<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name'     => 'Achievement 1'],
            ['name'     => 'Achievement 2'],
            ['name'     => 'Achievement 3'],
            ['name'     => 'Achievement 4'],
            ['name'     => 'Achievement 5'],
            ['name'     => 'Achievement 6'],
            ['name'     => 'Achievement 7'],
            ['name'     => 'Achievement 8'],
            ['name'     => 'Achievement 9'],
            ['name'     => 'Achievement 10'],
        ];

        Achievement::insert($data);
    }
}
