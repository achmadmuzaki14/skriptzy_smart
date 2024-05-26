<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreResult extends Model
{
    use HasFactory;

    protected $table = 'score_results';
    protected $guarded = [];

    public function alternative()
    {
        return $this->belongsTo(Alternative::class);
    }
}
