<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some regular users
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'mousamjainmj@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
            [
                'name' => 'Sarah Williams',
                'email' => 'sarah@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
            [
                'name' => 'David Brown',
                'email' => 'david@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        // Create additional random users using factory if available
        if (class_exists(\Database\Factories\UserFactory::class)) {
            User::factory(10)->create([
                'role' => 'user',
            ]);
        }
    }
}
