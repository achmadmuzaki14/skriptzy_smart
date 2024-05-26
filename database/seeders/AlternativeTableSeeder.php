<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Alternative;

class AlternativeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Alternative::create([
            'name' => 'Dito Nugroho',
            'community_id' => 1
        ]);
        Alternative::create([
            'name' => 'Iqbal Putra',
            'community_id' => 1
        ]);
        Alternative::create([
            'name' => 'Putri Damayanti',
            'community_id' => 1
        ]);
        Alternative::create([
            'name' => 'Fikri Ramadhan',
            'community_id' => 1
        ]);
        Alternative::create([
            'name' => 'Ayu Kartika',
            'community_id' => 1
        ]);
        Alternative::create([
            'name' => 'Dimas Aditya',
            'community_id' => 1
        ]);
        Alternative::create([
            'name' => 'Dian Permata',
            'community_id' => 1
        ]);
    }
}
