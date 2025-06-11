<?php

namespace Database\Seeders;

use App\Models\SuperAdmin;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       SuperAdmin::firstOrCreate(
            ['email' => 'superAdmin@gmail.com'],
            [
                'full_name' => 'Feras Abedullah',
                'password' => bcrypt('12345678'), // Alternatively: Hash::make()
            ]
        );
    }
}
