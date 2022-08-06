<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemain extends Model
{
    use HasFactory;

    protected $table = "pemains";
    protected $guarded = [];


    public function tim()
    {
        return $this->belongsTo(Tim::class);
    }
}
