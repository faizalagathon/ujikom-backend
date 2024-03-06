<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Album;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AlbumController
 */
final class AlbumControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $albums = Album::factory()->count(3)->create();

        $response = $this->get(route('album.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AlbumController::class,
            'store',
            \App\Http\Requests\AlbumStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $nama = $this->faker->word();
        $deskripsi = $this->faker->text();
        $tanggal = $this->faker->date();
        $user = User::factory()->create();

        $response = $this->post(route('album.store'), [
            'nama' => $nama,
            'deskripsi' => $deskripsi,
            'tanggal' => $tanggal,
            'user_id' => $user->id,
        ]);

        $albums = Album::query()
            ->where('nama', $nama)
            ->where('deskripsi', $deskripsi)
            ->where('tanggal', $tanggal)
            ->where('user_id', $user->id)
            ->get();
        $this->assertCount(1, $albums);
        $album = $albums->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $album = Album::factory()->create();

        $response = $this->get(route('album.show', $album));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AlbumController::class,
            'update',
            \App\Http\Requests\AlbumUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $album = Album::factory()->create();
        $nama = $this->faker->word();
        $deskripsi = $this->faker->text();
        $tanggal = $this->faker->date();
        $user = User::factory()->create();

        $response = $this->put(route('album.update', $album), [
            'nama' => $nama,
            'deskripsi' => $deskripsi,
            'tanggal' => $tanggal,
            'user_id' => $user->id,
        ]);

        $album->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($nama, $album->nama);
        $this->assertEquals($deskripsi, $album->deskripsi);
        $this->assertEquals(Carbon::parse($tanggal), $album->tanggal);
        $this->assertEquals($user->id, $album->user_id);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $album = Album::factory()->create();

        $response = $this->delete(route('album.destroy', $album));

        $response->assertNoContent();

        $this->assertModelMissing($album);
    }
}
