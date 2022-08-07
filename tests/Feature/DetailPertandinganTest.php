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

class DetailPertandinganTest extends TestCase
{
    use RefreshDatabase;


    public function test_it_store_true()
    {
        $user = User::factory()->create();
        $tim = Tim::factory()->count(3)->create();
        $pemain_tim_1 = Pemain::factory()->count(11)
            ->for($tim[0])
            ->create();
        $pemain_tim_2 = Pemain::factory()
            ->for($tim[1])
            ->count(11)->create();
        // $pemain_tim_3 = Pemain::factory()
        //     ->for($tim[2])
        //     ->count(11)->create();
        $pertandingan = Pertandingan::factory()
            ->for($tim[0], 'homeTim')
            ->for($tim[1], 'awayTim')
            ->create();
        $time = date('H:i:s');
        $response = $this->actingAs($user, 'sanctum')
            ->post(route('detail-pertandingan.store'), [
                'waktu' => $time,
                'pemain_id' => $pemain_tim_1[0]->id,
                'pertandingan_id' => $pertandingan->id,
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('detail_pertandingans', [
            'waktu' =>  $time,
            'pemain_id' => $pemain_tim_1[0]->id,
            'pertandingan_id' => $pertandingan->id,
        ]);
    }
    public function test_it_store_false()
    {
        $user = User::factory()->create();
        $tim = Tim::factory()->count(3)->create();
        $pemain_tim_1 = Pemain::factory()->count(11)
            ->for($tim[0])
            ->create();
        $pemain_tim_2 = Pemain::factory()
            ->for($tim[1])
            ->count(11)->create();
        $pemain_tim_3 = Pemain::factory()
            ->for($tim[2])
            ->count(11)->create();
        $pertandingan = Pertandingan::factory()
            ->for($tim[0], 'homeTim')
            ->for($tim[1], 'awayTim')
            ->create();

        $time = date('H:i:s');
        $response = $this->actingAs($user, 'sanctum')
            ->post(route('detail-pertandingan.store'), [
                'waktu' => $time,
                'pemain_id' => $pemain_tim_3[0]->id,
                'pertandingan_id' => $pertandingan->id,
            ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'error' => 'pemain yang anda masukan tidak ada pada tim yang bertanding',
        ]);
        $this->assertDatabaseMissing('detail_pertandingans', [
            'waktu' => $time,
            'pemain_id' => $pemain_tim_1[0]->id,
            'pertandingan_id' => $pertandingan->id,
        ]);
    }
    public function test_it_update()
    {
        $user = User::factory()->create();
        $tim = Tim::factory()->count(3)->create();
        $pemain_tim_1 = Pemain::factory()->count(11)
            ->for($tim[0])
            ->create();
        $pemain_tim_2 = Pemain::factory()
            ->for($tim[1])
            ->count(11)->create();
        // $pemain_tim_3 = Pemain::factory()
        //     ->for($tim[2])
        //     ->count(11)->create();
        $pertandingan = Pertandingan::factory()
            ->for($tim[0], 'homeTim')
            ->for($tim[1], 'awayTim')
            ->create();

        $detailPertandingan = DetailPertandingan::factory()
            ->for($pemain_tim_2[0], 'pemain')
            ->for($pertandingan, 'pertandingan')
            ->create();


        $time = date('H:i:s');
        $response = $this->actingAs($user, 'sanctum')
            ->put(route('detail-pertandingan.update', $detailPertandingan->id), [
                'waktu' => $time,
                'pemain_id' => $pemain_tim_1[0]->id,
                'pertandingan_id' => $pertandingan->id,
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('detail_pertandingans', [
            'id' => $detailPertandingan->id,
            'waktu' => $time,
            'pemain_id' => $pemain_tim_1[0]->id,
            'pertandingan_id' => $pertandingan->id,
        ]);
    }
    public function test_it_delete()
    {
        $user = User::factory()->create();
        $tim = Tim::factory()->count(3)->create();
        $pemain_tim_1 = Pemain::factory()->count(11)
            ->for($tim[0])
            ->create();
        $pemain_tim_2 = Pemain::factory()
            ->for($tim[1])
            ->count(11)->create();
        // $pemain_tim_3 = Pemain::factory()
        //     ->for($tim[2])
        //     ->count(11)->create();
        $pertandingan = Pertandingan::factory()
            ->for($tim[0], 'homeTim')
            ->for($tim[1], 'awayTim')
            ->create();

        $detailPertandingan = DetailPertandingan::factory()
            ->for($pemain_tim_2[0], 'pemain')
            ->for($pertandingan, 'pertandingan')
            ->create();


        $response = $this->actingAs($user, 'sanctum')
            ->delete(route('detail-pertandingan.destroy', $detailPertandingan->id));

        $response->assertStatus(200);
        $this->assertSoftDeleted('detail_pertandingans', [
            'id' => $detailPertandingan->id,
        ]);
    }
}
