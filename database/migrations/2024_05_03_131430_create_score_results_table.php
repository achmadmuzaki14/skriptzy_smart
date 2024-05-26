<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('score_results', function (Blueprint $table) {
            $table->id();
            $table->decimal('hasil_penilaian', 8, 4);
            $table->integer('rank');
            $table->bigInteger('alternative_id');
            // $table->bigInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('score_results');
    }
};
