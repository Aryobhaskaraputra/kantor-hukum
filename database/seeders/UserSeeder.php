<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'id' => 'KH00001',
            'nama_depan' => 'master',
            'nama_belakang' => 'master',
            'email' => 'master@example.com',
            'phone_number' => '08123456789',
            'nomor_induk_anggota' => '1234567890',
            'nomor_induk_kependudukan' => '1234567890123456',
            'alamat_lengkap' => 'Jalan Contoh No. 123',
            'negara' => 'Indonesia',
            'kota_kabupaten' => 'Jakarta Selatan',
            'kode_pos' => '12345',
            'role_id' => 1, // Assuming 1 is the role ID for master
            'email_verified_at' => now(),
            'password' => Hash::make('master123'), // Set your default password here
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'id' => 'KH00002',
            'nama_depan' => 'Admin',
            'nama_belakang' => 'Admin',
            'email' => 'admin@example.com',
            'phone_number' => '08123456789',
            'nomor_induk_anggota' => '1234567891',
            'nomor_induk_kependudukan' => '1234567890123457',
            'alamat_lengkap' => 'Jalan Contoh No. 123',
            'negara' => 'Indonesia',
            'kota_kabupaten' => 'Jakarta',
            'kode_pos' => '12345',
            'role_id' => 2, // Assuming 1 is the role ID for admin
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'), // Set your default password here
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create another user
        DB::table('users')->insert([
            'id' => 'KH00003',
            'nama_depan' => 'John',
            'nama_belakang' => 'Doe',
            'email' => 'john@example.com',
            'phone_number' => '08123456789',
            'nomor_induk_anggota' => '1234567892',
            'nomor_induk_kependudukan' => '1234567890123458',
            'alamat_lengkap' => 'Jalan Test No. 456',
            'negara' => 'Indonesia',
            'kota_kabupaten' => 'Bandung',
            'kode_pos' => '54321',
            'role_id' => 3,
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::factory()->count(50)->create();
    }
}
