<?php

namespace Tests\Feature;

use App\Models\DetailPertandingan;
use App\Models\Pemain;
use App\Models\Pertandingan;
use App\Models\Tim;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReportTest extends TestCase
{

    public function test_it_report()
    {
        $user = User::factory()->create();
        $tims = Tim::factory()->count(2)->create();
        $pemain_1 = Pemain::factory()->for($tims[0])->count(11)->create();
        $pemain_2 = Pemain::factory()->for($tims[1])->count(11)->create();
        $pertandingan = Pertandingan::factory()
            ->for($tims[0], 'homeTim')
            ->for($tims[1], 'awayTim')
            ->create();

        $detaiPertandingan = DetailPertandingan::factory()
            ->for($pemain_1[0])
            ->for($pertandingan)
            ->create();
        $detaiPertandingan = DetailPertandingan::factory()
            ->for($pemain_2[0])
            ->for($pertandingan)
            ->create();
        $detaiPertandingan = DetailPertandingan::factory()
            ->for($pemain_2[0])
            ->for($pertandingan)
            ->create();
        $response = $this->actingAs($user, 'sanctum')->get(route('report'));
        $response->assertStatus(200)
            ->assertJsonPath('data.0.tanggal', $pertandingan->tanggal)
            ->assertJsonPath('data.0.home_score', $pertandingan->scoreTimHome())
            ->assertJsonPath('data.0.away_score', $pertandingan->scoreTimAway())
            ->assertJsonPath('data.0.pencetak_goal_terbanyak.pemain_id', $pemain_2[0]->id);
    }
}
