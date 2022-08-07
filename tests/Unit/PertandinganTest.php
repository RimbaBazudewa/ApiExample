<?php

namespace Tests\Unit;

use App\Models\DetailPertandingan;
use App\Models\Pemain;
use App\Models\Pertandingan;
use App\Models\Tim;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PertandinganTest extends TestCase
{

    use RefreshDatabase;
    public function test_it_score_home()
    {
        $countPemainGoal =  3;
        $user = User::factory()->create();
        $tim = Tim::factory()->count(3)->create();
        $pemain_tim_1 = Pemain::factory()->count(11)
            ->for($tim[0])
            ->create();
        $pemain_tim_2 = Pemain::factory()
            ->for($tim[1])
            ->count(11)->create();
        $pertandingan = Pertandingan::factory()
            ->for($tim[0], 'homeTim')
            ->for($tim[1], 'awayTim')
            ->create();
        $detailPertandingan = DetailPertandingan::factory()
            ->for($pemain_tim_1[0], 'pemain')
            ->for($pertandingan, 'pertandingan')
            ->count($countPemainGoal)
            ->create();
        $score =  $pertandingan->scoreTimHome();
        $this->assertEquals($countPemainGoal, $score, 'score tidak sama');
    }
    public function test_it_score_away()
    {
        $countPemainGoal =  3;
        $user = User::factory()->create();
        $tim = Tim::factory()->count(3)->create();
        $pemain_tim_1 = Pemain::factory()->count(11)
            ->for($tim[0])
            ->create();
        $pemain_tim_2 = Pemain::factory()
            ->for($tim[1])
            ->count(11)->create();
        $pertandingan = Pertandingan::factory()
            ->for($tim[0], 'homeTim')
            ->for($tim[1], 'awayTim')
            ->create();
        $detailPertandingan = DetailPertandingan::factory()
            ->for($pemain_tim_2[0], 'pemain')
            ->for($pertandingan, 'pertandingan')
            ->count($countPemainGoal)
            ->create();
        $score =  $pertandingan->scoreTimAway();
        $this->assertEquals($countPemainGoal, $score, 'score tidak sama');
    }
}
