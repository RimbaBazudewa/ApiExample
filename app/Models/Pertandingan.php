<?php

namespace App\Models;

use Egulias\EmailValidator\Result\Reason\DetailedReason;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pertandingan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pertandingans';
    protected $guarded = [];

    public function detailPertandingans()
    {
        return $this->hasMany(DetailPertandingan::class);
    }

    public function homeTim()
    {
        return $this->belongsTo(Tim::class, 'home_tim_id');
    }
    public function awayTim()
    {
        return $this->belongsTo(Tim::class, 'away_tim_id');
    }
}
