<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Criteria;

class CriteriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Criteria::create([
            'name' => 'Kemampuan bahasa pemrograman',
            'bobot' => 0.5208,
            'community_id' => 1,
        ]);

        Criteria::create([
            'name' => 'Kemampuan manajemen basis data',
            'bobot' => 0.2708,
            'community_id' => 1,
        ]);

        Criteria::create([
            'name' => 'Kemampuan penggunaan framework',
            'bobot' => 0.1458,
            'community_id' => 1,
        ]);

        Criteria::create([
            'name' => 'Kemampuan penggunaan library/package',
            'bobot' => 0.0625,
            'community_id' => 1,
        ]);
    }
}
