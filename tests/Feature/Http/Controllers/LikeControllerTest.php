<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Foto;
use App\Models\Like;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\LikeController
 */
final class LikeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $likes = Like::factory()->count(3)->create();

        $response = $this->get(route('like.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LikeController::class,
            'store',
            \App\Http\Requests\LikeStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $foto = Foto::factory()->create();
        $user = User::factory()->create();
        $tanggal = $this->faker->date();

        $response = $this->post(route('like.store'), [
            'foto_id' => $foto->id,
            'user_id' => $user->id,
            'tanggal' => $tanggal,
        ]);

        $likes = Like::query()
            ->where('foto_id', $foto->id)
            ->where('user_id', $user->id)
            ->where('tanggal', $tanggal)
            ->get();
        $this->assertCount(1, $likes);
        $like = $likes->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $like = Like::factory()->create();

        $response = $this->get(route('like.show', $like));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LikeController::class,
            'update',
            \App\Http\Requests\LikeUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $like = Like::factory()->create();
        $foto = Foto::factory()->create();
        $user = User::factory()->create();
        $tanggal = $this->faker->date();

        $response = $this->put(route('like.update', $like), [
            'foto_id' => $foto->id,
            'user_id' => $user->id,
            'tanggal' => $tanggal,
        ]);

        $like->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($foto->id, $like->foto_id);
        $this->assertEquals($user->id, $like->user_id);
        $this->assertEquals(Carbon::parse($tanggal), $like->tanggal);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $like = Like::factory()->create();

        $response = $this->delete(route('like.destroy', $like));

        $response->assertNoContent();

        $this->assertModelMissing($like);
    }
}
