<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;

    protected $table = 'communities';
    protected $guarded = [];


    public function alternative()
    {
        return $this->hasMany(Alternative::class, 'community_id');
    }

    public function criteria()
    {
        return $this->hasMany(Criteria::class, 'community_id');
    }
}
