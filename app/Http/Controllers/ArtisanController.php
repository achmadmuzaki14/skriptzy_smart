<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ArtisanController extends Controller
{
    public function migrateAndSeed()
    {
        try {
            // Menjalankan perintah artisan migrate:fresh --seed
            Artisan::call('migrate:fresh --seed');
            // Mengambil output dari perintah artisan
            $output = Artisan::output();

            // Menampilkan output sebagai response
            return response()->json([
                'status' => 'success',
                'message' => 'Database migrated and seeded successfully!',
                'output' => $output,
            ]);
        } catch (\Exception $e) {
            // Menangani error
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to migrate and seed database!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
