<?php

namespace Tests\Feature;

use App\Models\Tim;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class TimTest extends TestCase
{
    use RefreshDatabase;
    public function test_it_index()
    {
        $user = User::factory()->create();
        $tim = Tim::factory()->create();
        $response = $this->actingAs($user, 'sanctum')->get(route('tim.index'));
        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has(
                    'data',
                )
            );
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_store()
    {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('testimage.png');
        $response = $this->actingAs($user, 'sanctum')
            ->post(route('tim.store'),        [
                "nama"  => 'test nama',
                "logo" => $file,
                "tahun" => '2020',
                "alamat" => 'test alamat test alamant ',
                "kota" => 'test kota',
            ]);

        $response->assertStatus(200);
        $this->assertFileExists(storage_path('app/public'), $user->id  . $file->hashName());
    }
    public function test_it_show()
    {
        $user = User::factory()->create();
        $tim = Tim::factory()->create();
        $response = $this->actingAs($user, 'sanctum')->get(route('tim.show', $tim->id));
        $response->assertStatus(200)
            ->assertJsonPath('data.id', $tim->id)
            ->assertJsonPath('data.nama', $tim->nama);
    }
    public function test_it_update_with_file()
    {
        $user = User::factory()->create();
        $tim = Tim::factory()->create();
        $file = UploadedFile::fake()->image('testimage.png');
        $response = $this->actingAs($user, 'sanctum')
            ->put(route('tim.update', $tim->id),        [
                "nama"  => 'test nama',
                "logo" => $file,
                "tahun" => '2020',
                "alamat" => 'test alamat test alamant ',
                "kota" => 'test kota',
            ]);

        $response->assertStatus(200);
        $this->assertFileExists(storage_path('app/public'), 'testnama'  . $file->hashName());
        $this->assertDatabaseHas($tim->getTable(), [
            "id" => $tim->id,
            "nama" => 'test nama',
            "logo" => 'public/testnama'   . $file->hashName(),
        ]);
    }
    public function test_it_update_without_file()
    {
        $user = User::factory()->create();
        $tim = Tim::factory()->create();
        $response = $this->actingAs($user, 'sanctum')
            ->put(route('tim.update', $tim->id),        [
                "nama"  => 'test nama',
                "logo" => '',
                "tahun" => '2020',
                "alamat" => 'test alamat test alamant ',
                "kota" => 'test kota',
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas($tim->getTable(), [
            "id" => $tim->id,
            "nama" => 'test nama',
            "logo" => $tim->logo,
        ]);
    }
    public function test_it_delete()
    {
        $user = User::factory()->create();
        $tim = Tim::factory()->create();
        $response = $this->actingAs($user, 'sanctum')
            ->delete(route('tim.destroy', $tim->id));

        $response->assertStatus(200);
        $this->assertSoftDeleted($tim->getTable(), [
            'id' => $tim->id,
        ]);
    }
}
