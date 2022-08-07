<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPertandingan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table  = "detail_pertandingans";
    protected $guarded = [];

    public function pertandingan()
    {
        return $this->belongsTo(Pertandingan::class);
    }
    public function pemain()
    {
        return $this->belongsTo(Pemain::class);
    }
}
