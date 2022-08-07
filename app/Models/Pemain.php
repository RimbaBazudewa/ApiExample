<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemain extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "pemains";
    protected $guarded = [];

    public function detailPertandingan()
    {
        return $this->hasMany(DetailPertandingan::class);
    }

    public function tim()
    {
        return $this->belongsTo(Tim::class);
    }
}
