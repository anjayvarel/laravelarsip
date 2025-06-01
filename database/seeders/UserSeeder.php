<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat role jika belum ada
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'staff']);

        // Buat user admin
        $admin = User::create([
            'nama' => 'Raja Varel', // HARUS 'nama', bukan 'name'
            'nip' => '123456',
            'password' => 'password123',
            'role' => 'admin', // Pastikan sesuai migrasi
        ]);
        $admin->assignRole('admin');

        // Buat user staff
        $staff = User::create([
            'nama' => 'Staff User',
            'nip' => '654321',
            'password' => 'password123',
            'role' => 'staff',
        ]);
        $staff->assignRole('staff');
    }
}
