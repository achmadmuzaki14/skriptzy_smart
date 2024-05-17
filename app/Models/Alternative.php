<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    use HasFactory;

    protected $table = 'alternatives';
    protected $guarded = [];

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function ScoreResult()
    {
        return $this->belongsTo(ScoreResult::class);
    }

    public function AlternativeValue()
    {
        return $this->hasMany(AlternativeValue::class, 'alternative_id');
    }
}
