<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\DetailPertandinganController;
use App\Models\DetailPertandingan;
use App\Models\Pemain;
use App\Models\Pertandingan;
use App\Models\Tim;
use Illuminate\Foundation\Testing\RefreshDatabase;
use ReflectionClass;
use Tests\TestCase;

class DetailPertandinganTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_check_pemain_tim_1_true()
    {
        $tim = Tim::factory()->count(2)->create();
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

        $detailPertandinganController = new DetailPertandinganController();
        $reflection = new ReflectionClass('App\Http\Controllers\Api\DetailPertandinganController');
        $method = $reflection->getMethod('checkPemain');
        $method->setAccessible(true);
        $result = $method->invokeArgs($detailPertandinganController, [
            $pemain_tim_1[0]->id,
            $pertandingan->id,
        ]);

        $this->assertTrue($result, "must true result");
    }
    public function test_it_check_pemain_tim_2_true()
    {
        $tim = Tim::factory()->count(2)->create();
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

        $detailPertandinganController = new DetailPertandinganController();
        $reflection = new ReflectionClass('App\Http\Controllers\Api\DetailPertandinganController');
        $method = $reflection->getMethod('checkPemain');
        $method->setAccessible(true);
        $result = $method->invokeArgs($detailPertandinganController, [
            $pemain_tim_2[0]->id,
            $pertandingan->id,
        ]);

        $this->assertTrue($result, "must true result");
    }

    public function test_it_check_pemain_false()
    {
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

        $detailPertandinganController = new DetailPertandinganController();
        $reflection = new ReflectionClass('App\Http\Controllers\Api\DetailPertandinganController');
        $method = $reflection->getMethod('checkPemain');
        $method->setAccessible(true);
        $result = $method->invokeArgs($detailPertandinganController, [
            $pemain_tim_3[0]->id,
            $pertandingan->id,
        ]);

        $this->assertTrue(!$result, "must false result");
    }
}
