<?php

namespace Tests\Feature;

use App\Models\Pemain;
use App\Models\Tim;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PemainTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_store()
    {
        $user = User::factory()->create();
        $tim = Tim::factory()->create();
        $response = $this->actingAs($user, 'sanctum')
            ->post(route('pemain.store'), [
                "nama" => 'test_pemain',
                "tinggi_badan" => 160,
                "berat_badan" => 55,
                "posisi" => "penyerang",
                "no_punggung" => 7,
                "tim_id" => $tim->id,
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('pemains', [
            'nama' => 'test_pemain',
            'tim_id' => $tim->id,
        ]);
        $tim2 = Tim::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->post(route('pemain.store'), [
                "nama" => 'test_pemain',
                "tinggi_badan" => 160,
                "berat_badan" => 55,
                "posisi" => "penyerang",
                "no_punggung" => 7,
                "tim_id" => $tim2->id,
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('pemains', [
            'nama' => 'test_pemain',
            'tim_id' => $tim->id,
        ]);
    }
    public function test_it_update()
    {
        $user = User::factory()->create();
        $tim = Tim::factory()->create();
        $pemain = Pemain::factory()->for($tim)->create();
        $response = $this->actingAs($user, 'sanctum')
            ->put(route('pemain.update', $pemain->id), [
                "nama" => 'test_pemain',
                "tinggi_badan" => 160,
                "berat_badan" => 55,
                "posisi" => "penyerang",
                "no_punggung" => $pemain->no_punggung,
                "tim_id" => $tim->id,
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('pemains', [
            'nama' => 'test_pemain',
            'tim_id' => $tim->id,
        ]);
        $this->assertDatabaseMissing('pemains', [
            'nama' => $pemain->nama,
        ]);
    }
    public function test_it_delete()
    {
        $user = User::factory()->create();
        $tim = Tim::factory()->create();
        $pemain = Pemain::factory()->for($tim)->create();
        $response = $this->actingAs($user, 'sanctum')
            ->delete(route('pemain.destroy', $pemain->id));

        $response->assertStatus(200);
        $this->assertSoftDeleted('pemains', [
            'id' => $pemain->id,
            'nama' => $pemain->nama,
        ]);
    }
}
