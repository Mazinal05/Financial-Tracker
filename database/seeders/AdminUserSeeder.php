<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Remove old admin if exists
        User::where('email', 'admin@example.com')->delete();

        // Create or Update new Admin
        User::updateOrCreate(
            ['email' => 'admin@financetracker.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('ceksaldo123@'),
                'role' => 'admin',
                'is_banned' => false,
            ]
        );
        
        $this->command->info('Admin user updated: admin@financetracker.com / ceksaldo123@');
    }
}
