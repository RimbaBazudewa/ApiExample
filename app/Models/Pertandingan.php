<?php

namespace App\Models;

use Egulias\EmailValidator\Result\Reason\DetailedReason;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Pertandingan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pertandingans';
    protected $guarded = [];

    protected $appends = [
        'home_score',
        'away_score',
        'status_akhir',
        'pencetak_goal_terbanyak',
        'total_kemenangan_tim_home',
        'total_kemenangan_tim_away',
    ];
    public function getHomeScoreAttribute()
    {
        return $this->scoreTimHome();
    }
    public function getAwayScoreAttribute()
    {
        return $this->scoreTimAway();
    }
    public function getStatusAkhirAttribute()
    {
        return $this->home_score > $this->away_score ? 'Tim Home Menang' : ($this->home_score == $this->away_score ?  'Draw' : 'Tim Away Menang');
    }
    public function getPencetakGoalTerbanyakAttribute()
    {
        return $this->detailPertandingans()->with('pemain')->get()->groupBy('pemain_id')->map(function ($item, $key) {
            return ['name' => $item->first()->pemain->nama, 'pemain_id' => $item->first()->pemain_id, 'count' => $item->count()];
        })->sortByDesc('count')->first();
    }
    public function getTotalKemenanganTimHomeAttribute()
    {
        return self::where('home_tim_id', $this->home_tim_id)->get()->where('home_score', '>', 'away_score')->count();
    }
    public function getTotalKemenanganTimAwayAttribute()
    {
        return self::where('away_tim_id', $this->away_tim_id)->get()->where('home_score', '<', 'away_score')->count();
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
