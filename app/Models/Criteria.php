<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;

    protected $table = 'criterias';
    protected $guarded = [];


    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function community()
    {
        return $this->belongsTo(Community::class);
    }
}
