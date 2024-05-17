<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlternativeValue extends Model
{
    use HasFactory;


    public function Alternative()
    {
        return $this->belongsTo(Alternative::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

}
