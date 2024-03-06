<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'username' => $this->faker->userName(),
            'password' => $this->faker->password(),
            'email' => $this->faker->safeEmail(),
            'nama_lengkap' => $this->faker->word(),
            'alamat' => $this->faker->text(),
        ];
    }
}
