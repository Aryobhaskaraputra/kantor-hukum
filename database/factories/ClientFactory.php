<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{

    protected $model = Client::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_depan' => $this->faker->firstName,
            'nama_belakang' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone_number' => $this->faker->phoneNumber,
            'nomor_induk_kependudukan' => $this->faker->unique()->numerify('###########'),
            'alamat_lengkap' => $this->faker->address,
            'negara' => $this->faker->country,
            'kota_kabupaten' => $this->faker->city,
            'kode_pos' => $this->faker->postcode,
        ];
    }
}
