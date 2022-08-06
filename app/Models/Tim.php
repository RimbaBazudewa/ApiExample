<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tim extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "tims";
    protected $guarded = [];

    public function pemains()
    {
        return $this->hasMany(Pemain::class);
    }
}
