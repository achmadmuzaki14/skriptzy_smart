<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'name' => 'Agung Teguh',
            'email' => 'admin@pembimbing.com',
            'password' => Hash::make('secret'),
            'role' => 'pembimbing',
            'about' => "Hi, I’m Agung Teguh, Decisions: If you can’t decide, the answer is no. If two equally difficult paths, choose the one more painful in the short term (pain avoidance is creating an illusion of equality).",
        ]);

        User::factory()->create([
            'name' => 'Alec Thompson',
            'email' => 'admin@corporateui.com',
            'password' => Hash::make('secret'),
            'role' => 'super_admin',
            'about' => "Hi, I’m Alec Thompson, Decisions: If you can’t decide, the answer is no. If two equally difficult paths, choose the one more painful in the short term (pain avoidance is creating an illusion of equality).",
        ]);

        $this->call([
            CommunityTableSeeder::class,
            CriteriaTableSeeder::class,
            AlternativeTableSeeder::class,
            AlternativeValueTableSeeder::class,
          ]);
    }
}
