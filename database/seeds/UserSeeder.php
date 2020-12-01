<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        factory(User::class)->create(
            [
            'email' => 'admin@mercatodo.com',
            'password' => Hash::make('admin123'),
            'role_id' => '1',
            ]
        );

        factory(User::class, 15)->create();
    }
}
