<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    private const ROLES = [
        'SUPER_ADMIN' => 'super_admin',
        'ADMIN' => 'admin',
        'USER' => 'user'
    ];

    private const STATUS_ACTIVE = 'active';

    public function run(): void
    {
        try {
            $now = Carbon::now();

            $users = [
                [
                    'name' => 'Super Admin',
                    'username' => 'superadmin',
                    'email' => 'superadmin@example.com',
                    'password' => Hash::make('Minhaz@1332'),
                    'role' => self::ROLES['SUPER_ADMIN'],
                    'status' => self::STATUS_ACTIVE,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'name' => 'Admin User',
                    'username' => 'adminuser',
                    'email' => 'adminuser@gmail.com',
                    'password' => Hash::make('111'),
                    'role' => self::ROLES['ADMIN'],
                    'status' => self::STATUS_ACTIVE,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'name' => 'Regular User',
                    'username' => 'regularuser',
                    'email' => 'user@gmail.com',
                    'password' => Hash::make('111'),
                    'role' => self::ROLES['USER'],
                    'status' => self::STATUS_ACTIVE,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ];

            // Use chunk insert if dealing with large datasets
            collect($users)->chunk(100)->each(function ($chunk) {
                DB::table('users')->insert($chunk->toArray());
            });
        } catch (\Exception $e) {
            $this->command->error('Error seeding users: ' . $e->getMessage());
        }
    }
}
