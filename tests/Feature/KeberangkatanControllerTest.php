<?php

namespace Tests\Feature;

use App\Models\Bus;
use App\Models\Keberangkatan;
use App\Models\Lokasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class KeberangkatanControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Bus $bus;
    protected Lokasi $lokasi;

    protected function setUp(): void
    {
        parent::setUp();

        // Login user
        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        $this->actingAs($this->user);

        // Master data
        $this->bus = Bus::create([
            'kode_bus' => 'BUS001',
        ]);

        $this->lokasi = Lokasi::create([
            'nama_lokasi' => 'Jakarta',
        ]);
    }

    /** @test */
    public function index_page_can_be_loaded()
    {
        $response = $this->get(route('keberangkatan.index'));

        $response
            ->assertOk()
            ->assertInertia(fn (Assert $page) =>
                $page->component('Keberangkatan/Index')
            );
    }

    /** @test */
    public function create_page_can_be_loaded()
    {
        $response = $this->get(route('keberangkatan.create'));

        $response
            ->assertOk()
            ->assertInertia(fn (Assert $page) =>
                $page->component('Keberangkatan/Create')
                    ->has('buses')
                    ->has('lokasis')
            );
    }

    /** @test */
    public function user_can_create_keberangkatan()
    {
        $response = $this->post(route('keberangkatan.store'), [
            'bus_id' => $this->bus->id,
            'tujuan_id' => $this->lokasi->id,
            'waktu_keberangkatan' => '08:00:00',
            'status' => 2,
        ]);

        $response->assertRedirect(route('keberangkatan.index'));

        $this->assertDatabaseHas('keberangkatans', [
            'bus_id' => $this->bus->id,
            'tujuan_id' => $this->lokasi->id,
            'status' => 2,
        ]);
    }

    /** @test */
    public function edit_page_can_be_loaded()
    {
        $keberangkatan = Keberangkatan::create([
            'bus_id' => $this->bus->id,
            'tujuan_id' => $this->lokasi->id,
            'waktu_keberangkatan' => '08:00:00',
            'status' => 2,
        ]);

        $response = $this->get(
            route('keberangkatan.edit', $keberangkatan)
        );

        $response
            ->assertOk()
            ->assertInertia(fn (Assert $page) =>
                $page->component('Keberangkatan/Edit')
                    ->has('keberangkatan')
                    ->has('buses')
                    ->has('lokasis')
            );
    }

    /** @test */
    public function user_can_update_keberangkatan()
    {
        $keberangkatan = Keberangkatan::create([
            'bus_id' => $this->bus->id,
            'tujuan_id' => $this->lokasi->id,
            'waktu_keberangkatan' => '08:00:00',
            'status' => 2,
        ]);

        $response = $this->put(
            route('keberangkatan.update', $keberangkatan),
            [
                'bus_id' => $this->bus->id,
                'tujuan_id' => $this->lokasi->id,
                'waktu_keberangkatan' => '15:30:00',
                'status' => 1,
            ]
        );

        $response->assertRedirect(route('keberangkatan.index'));

        $this->assertDatabaseHas('keberangkatans', [
            'id' => $keberangkatan->id,
            'waktu_keberangkatan' => '15:30:00',
            'status' => 1,
        ]);
    }

    /** @test */
    public function user_can_delete_keberangkatan()
    {
        $keberangkatan = Keberangkatan::create([
            'bus_id' => $this->bus->id,
            'tujuan_id' => $this->lokasi->id,
            'waktu_keberangkatan' => '08:00:00',
            'status' => 2,
        ]);

        $response = $this->delete(
            route('keberangkatan.destroy', $keberangkatan)
        );

        $response->assertRedirect(route('keberangkatan.index'));

        $this->assertDatabaseMissing('keberangkatans', [
            'id' => $keberangkatan->id,
        ]);
    }

    /** @test */
    public function reset_jadwal_changes_all_status_to_two()
    {
        for ($i = 0; $i < 3; $i++) {
            Keberangkatan::create([
                'bus_id' => $this->bus->id,
                'tujuan_id' => $this->lokasi->id,
                'waktu_keberangkatan' => '08:00:00',
                'status' => 4,
            ]);
        }

        $response = $this->get(route('resetJadwal'));

        $response->assertRedirect(route('keberangkatan.index'));

        $this->assertEquals(
            3,
            Keberangkatan::where('status', 2)->count()
        );
    }
}