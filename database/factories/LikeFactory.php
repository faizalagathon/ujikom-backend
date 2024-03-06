<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Foto;
use App\Models\Like;
use App\Models\User;

class LikeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Like::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'foto_id' => Foto::factory(),
            'user_id' => User::factory(),
            'tanggal' => $this->faker->date(),
        ];
    }
}
