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

    protected $appends = [
        'home_score',
        'away_score',
    ];
    public function getHomeScoreAttribute()
    {
        return $this->scoreTimHome();
    }
    public function getAwayScoreAttribute()
    {
        return $this->scoreTimAway();
    }
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
    public function scoreTimHome()
    {
        return $this->detailPertandingans()->whereHas('pemain', function ($q) {
            $q->whereHas('tim', function ($k) {
                $k->where('id', $this->home_tim_id);
            });
        })->count();
    }
    public function scoreTimAway()
    {
        return $this->detailPertandingans()->whereHas('pemain', function ($q) {
            $q->whereHas('tim', function ($k) {
                $k->where('id', $this->away_tim_id);
            });
        })->count();
    }
}
