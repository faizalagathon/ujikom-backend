<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Foto;
use App\Models\Komentar;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\KomentarController
 */
final class KomentarControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $komentars = Komentar::factory()->count(3)->create();

        $response = $this->get(route('komentar.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\KomentarController::class,
            'store',
            \App\Http\Requests\KomentarStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $foto = Foto::factory()->create();
        $user = User::factory()->create();
        $isi = $this->faker->text();
        $tanggal = $this->faker->date();

        $response = $this->post(route('komentar.store'), [
            'foto_id' => $foto->id,
            'user_id' => $user->id,
            'isi' => $isi,
            'tanggal' => $tanggal,
        ]);

        $komentars = Komentar::query()
            ->where('foto_id', $foto->id)
            ->where('user_id', $user->id)
            ->where('isi', $isi)
            ->where('tanggal', $tanggal)
            ->get();
        $this->assertCount(1, $komentars);
        $komentar = $komentars->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $komentar = Komentar::factory()->create();

        $response = $this->get(route('komentar.show', $komentar));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\KomentarController::class,
            'update',
            \App\Http\Requests\KomentarUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $komentar = Komentar::factory()->create();
        $foto = Foto::factory()->create();
        $user = User::factory()->create();
        $isi = $this->faker->text();
        $tanggal = $this->faker->date();

        $response = $this->put(route('komentar.update', $komentar), [
            'foto_id' => $foto->id,
            'user_id' => $user->id,
            'isi' => $isi,
            'tanggal' => $tanggal,
        ]);

        $komentar->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($foto->id, $komentar->foto_id);
        $this->assertEquals($user->id, $komentar->user_id);
        $this->assertEquals($isi, $komentar->isi);
        $this->assertEquals(Carbon::parse($tanggal), $komentar->tanggal);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $komentar = Komentar::factory()->create();

        $response = $this->delete(route('komentar.destroy', $komentar));

        $response->assertNoContent();

        $this->assertModelMissing($komentar);
    }
}
