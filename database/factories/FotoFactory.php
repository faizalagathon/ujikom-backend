<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Album;
use App\Models\Foto;
use App\Models\User;

class FotoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Foto::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'judul' => $this->faker->word(),
            'deskripsi' => $this->faker->text(),
            'tanggal' => $this->faker->date(),
            'file' => $this->faker->word(),
            'album_id' => Album::factory(),
            'user_id' => User::factory(),
        ];
    }
}
