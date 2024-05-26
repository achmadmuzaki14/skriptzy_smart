<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Community;

class CommunityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Community::create([
            'name' => 'weboender'
        ]);
        Community::create([
            'name' => 'gdsc'
        ]);
        Community::create([
            'name' => 'mocap'
        ]);
        Community::create([
            'name' => 'funjava'
        ]);
        Community::create([
            'name' => 'uinux'
        ]);
        Community::create([
            'name' => 'uinbuntu'
        ]);
        Community::create([
            'name' => 'eth0'
        ]);
        Community::create([
            'name' => 'dse'
        ]);
        Community::create([
            'name' => 'mamud'
        ]);
        Community::create([
            'name' => 'ontaki'
        ]);
    }
}
