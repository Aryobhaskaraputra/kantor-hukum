<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

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
     *
     * @return array
     */


    public function definition()
    {
        $faker = Faker::create('id_ID');

        return [
            'id' => 'KH' . $this->faker->unique()->numberBetween(1, 99999),
            'nama_depan' => $faker->firstName,
            'nama_belakang' => $faker->lastName,
            'email' => $faker->unique()->safeEmail,
            'phone_number' => $faker->phoneNumber,
            'nomor_induk_anggota' => $faker->numerify('############'),
            'nomor_induk_kependudukan' => $faker->numerify('################'),
            'alamat_lengkap' => $faker->address,
            'negara' => 'Indonesia',
            'kota_kabupaten' => $faker->city,
            'kode_pos' => $faker->postcode,
            'role_id' => 3,
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
