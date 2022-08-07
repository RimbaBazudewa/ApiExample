<?php

namespace Tests\Feature;

use App\Models\Pertandingan;
use App\Models\Tim;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PertandinganTest extends TestCase
{
    use RefreshDatabase;
    public function test_it_index()
    {
        $user = User::factory()->create();
        $pertandingan = Pertandingan::factory()
            ->for(Tim::factory(), 'homeTim')
            ->for(Tim::factory(), 'awayTim')
            ->create();
        $response = $this->actingAs($user, 'sanctum')->get(route('pertandingan.index'));
        $response->assertStatus(200)
            ->assertJsonPath('data.0.tanggal', $pertandingan->tanggal);
    }
    public function test_it_store()
    {

        $user = User::factory()->create();
        $tims = Tim::factory()->count(2)->create();
        $response = $this->actingAs($user, 'sanctum')
            ->post(route('pertandingan.store'), [
                "tanggal" => date('Y-m-d'),
                "waktu"  => date('H:i'),
                'home_tim_id' => $tims[0]->id,
                'away_tim_id' => $tims[1]->id,
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('pertandingans', [
            'tanggal' => date('Y-m-d'),
            'waktu' => date('H:i'),
            'home_tim_id' => $tims[0]->id,
            'away_tim_id' => $tims[1]->id,
        ]);
    }
    public function test_it_show()
    {
        $user = User::factory()->create();
        $pertandingan = Pertandingan::factory()
            ->for(Tim::factory(), 'homeTim')
            ->for(Tim::factory(), 'awayTim')
            ->create();
        $response = $this->actingAs($user, 'sanctum')->get(route('pertandingan.show', $pertandingan->id));
        $response->assertStatus(200)
            ->assertJsonPath('data.tanggal', $pertandingan->tanggal);
    }
    public function test_it_update()
    {
        $user = User::factory()->create();
        $tims = Tim::factory()->count(2)->create();
        $pertandingan = Pertandingan::factory()
            ->for(Tim::factory(), 'homeTim')
            ->for(Tim::factory(), 'awayTim')
            ->create();
        $response = $this->actingAs($user, 'sanctum')
            ->put(route('pertandingan.update', $pertandingan->id), [
                "tanggal" => date('Y-m-d'),
                "waktu"  => date('H:i'),
                'home_tim_id' => $tims[0]->id,
                'away_tim_id' => $tims[1]->id,
            ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('pertandingans', [
            'tanggal' => date('Y-m-d'),
            'waktu' => date('H:i'),
            'home_tim_id' => $tims[0]->id,
            'away_tim_id' => $tims[1]->id,
        ]);
    }
    public function test_it_delete()
    {
        $user = User::factory()->create();
        $pertandingan = Pertandingan::factory()
            ->for(Tim::factory(), 'homeTim')
            ->for(Tim::factory(), 'awayTim')
            ->create();
        $response = $this->actingAs($user, 'sanctum')
            ->delete(route('pertandingan.destroy', $pertandingan->id));
        $response->assertStatus(200);
        $this->assertSoftDeleted('pertandingans', [
            'id' => $pertandingan->id,
            'tanggal' => $pertandingan->tanggal,
            'waktu' => $pertandingan->waktu,
        ]);
    }
}
