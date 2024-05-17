<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AlternativeValue;

class AlternativeValueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AlternativeValue::create([
            'value' => 90,
            'alternative_id' => 1,
            'criteria_id' => 1,
            'user_id' => 1,
        ]);
        AlternativeValue::create([
            'value' => 70,
            'alternative_id' => 1,
            'criteria_id' => 2,
            'user_id' => 1,
        ]);
        AlternativeValue::create([
            'value' => 90,
            'alternative_id' => 1,
            'criteria_id' => 3,
            'user_id' => 1,
        ]);
        AlternativeValue::create([
            'value' => 75,
            'alternative_id' => 1,
            'criteria_id' => 4,
            'user_id' => 1,
        ]);
        AlternativeValue::create([
            'value' => 75,
            'alternative_id' => 2,
            'criteria_id' => 1,
            'user_id' => 1,
        ]);
        AlternativeValue::create([
            'value' => 75,
            'alternative_id' => 2,
            'criteria_id' => 2,
            'user_id' => 1,
        ]);
        AlternativeValue::create([
            'value' => 100,
            'alternative_id' => 2,
            'criteria_id' => 3,
            'user_id' => 1,
        ]);
        AlternativeValue::create([
            'value' => 80,
            'alternative_id' => 2,
            'criteria_id' => 4,
            'user_id' => 1,
        ]);
        AlternativeValue::create([
            'value' => 85,
            'alternative_id' => 3,
            'criteria_id' => 1,
            'user_id' => 1,
        ]);
        AlternativeValue::create([
            'value' => 80,
            'alternative_id' => 3,
            'criteria_id' => 2,
            'user_id' => 1,
        ]);
        AlternativeValue::create([
            'value' => 95,
            'alternative_id' => 3,
            'criteria_id' => 3,
            'user_id' => 1,
        ]);
        AlternativeValue::create([
            'value' => 95,
            'alternative_id' => 3,
            'criteria_id' => 4,
            'user_id' => 1,
        ]);
        AlternativeValue::create([
            'value' => 80,
            'alternative_id' => 4,
            'criteria_id' => 1,
            'user_id' => 1,
        ]);
        AlternativeValue::create([
            'value' => 85,
            'alternative_id' => 4,
            'criteria_id' => 2,
            'user_id' => 1,
        ]);
        AlternativeValue::create([
            'value' => 80,
            'alternative_id' => 4,
            'criteria_id' => 3,
            'user_id' => 1,
        ]);
        AlternativeValue::create([
            'value' => 90,
            'alternative_id' => 4,
            'criteria_id' => 4,
            'user_id' => 1,
        ]);
        AlternativeValue::create([
            'value' => 90,
            'alternative_id' => 5,
            'criteria_id' => 1,
            'user_id' => 1,
        ]);
        AlternativeValue::create([
            'value' => 90,
            'alternative_id' => 5,
            'criteria_id' => 2,
            'user_id' => 1,
        ]);
        AlternativeValue::create([
            'value' => 85,
            'alternative_id' => 5,
            'criteria_id' => 3,
            'user_id' => 1,
        ]);
        AlternativeValue::create([
            'value' => 95,
            'alternative_id' => 5,
            'criteria_id' => 4,
            'user_id' => 1,
        ]);
        AlternativeValue::create([
            'value' => 75,
            'alternative_id' => 6,
            'criteria_id' => 1,
            'user_id' => 1,
        ]);
        AlternativeValue::create([
            'value' => 95,
            'alternative_id' => 6,
            'criteria_id' => 2,
            'user_id' => 1,
        ]);
        AlternativeValue::create([
            'value' => 75,
            'alternative_id' => 6,
            'criteria_id' => 3,
            'user_id' => 1,
        ]);
        AlternativeValue::create([
            'value' => 75,
            'alternative_id' => 6,
            'criteria_id' => 4,
            'user_id' => 1,
        ]);
        AlternativeValue::create([
            'value' => 85,
            'alternative_id' => 7,
            'criteria_id' => 1,
            'user_id' => 1,
        ]);
        AlternativeValue::create([
            'value' => 85,
            'alternative_id' => 7,
            'criteria_id' => 2,
            'user_id' => 1,
        ]);
        AlternativeValue::create([
            'value' => 60,
            'alternative_id' => 7,
            'criteria_id' => 3,
            'user_id' => 1,
        ]);
        AlternativeValue::create([
            'value' => 70,
            'alternative_id' => 7,
            'criteria_id' => 4,
            'user_id' => 1,
        ]);

    }
}
