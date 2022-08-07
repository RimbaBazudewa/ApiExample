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

    protected $appends = [
        'total_kemenangan_home',
        'total_kemenangan_away',
    ];
    public function getTotalKemenanganHomeAttribute()
    {
        return   $this->homePertandingans()->count();
    }
    public function getTotalKemenanganAwayAttribute()
    {
        return $this->awayPertandingans()->count();
    }
    public function pemains()
    {
        return $this->hasMany(Pemain::class);
    }
    public function homePertandingans()
    {
        return $this->hasMany(Pertandingan::class, 'home_tim_id');
    }
    public function awayPertandingans()
    {
        return $this->hasMany(Pertandingan::class, 'away_tim_id');
    }
}
