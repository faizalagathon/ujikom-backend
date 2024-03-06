<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Album;
use App\Models\Foto;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\FotoController
 */
final class FotoControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $fotos = Foto::factory()->count(3)->create();

        $response = $this->get(route('foto.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\FotoController::class,
            'store',
            \App\Http\Requests\FotoStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $judul = $this->faker->word();
        $deskripsi = $this->faker->text();
        $tanggal = $this->faker->date();
        $file = $this->faker->word();
        $album = Album::factory()->create();
        $user = User::factory()->create();

        $response = $this->post(route('foto.store'), [
            'judul' => $judul,
            'deskripsi' => $deskripsi,
            'tanggal' => $tanggal,
            'file' => $file,
            'album_id' => $album->id,
            'user_id' => $user->id,
        ]);

        $fotos = Foto::query()
            ->where('judul', $judul)
            ->where('deskripsi', $deskripsi)
            ->where('tanggal', $tanggal)
            ->where('file', $file)
            ->where('album_id', $album->id)
            ->where('user_id', $user->id)
            ->get();
        $this->assertCount(1, $fotos);
        $foto = $fotos->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $foto = Foto::factory()->create();

        $response = $this->get(route('foto.show', $foto));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\FotoController::class,
            'update',
            \App\Http\Requests\FotoUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $foto = Foto::factory()->create();
        $judul = $this->faker->word();
        $deskripsi = $this->faker->text();
        $tanggal = $this->faker->date();
        $file = $this->faker->word();
        $album = Album::factory()->create();
        $user = User::factory()->create();

        $response = $this->put(route('foto.update', $foto), [
            'judul' => $judul,
            'deskripsi' => $deskripsi,
            'tanggal' => $tanggal,
            'file' => $file,
            'album_id' => $album->id,
            'user_id' => $user->id,
        ]);

        $foto->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($judul, $foto->judul);
        $this->assertEquals($deskripsi, $foto->deskripsi);
        $this->assertEquals(Carbon::parse($tanggal), $foto->tanggal);
        $this->assertEquals($file, $foto->file);
        $this->assertEquals($album->id, $foto->album_id);
        $this->assertEquals($user->id, $foto->user_id);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $foto = Foto::factory()->create();

        $response = $this->delete(route('foto.destroy', $foto));

        $response->assertNoContent();

        $this->assertModelMissing($foto);
    }
}
