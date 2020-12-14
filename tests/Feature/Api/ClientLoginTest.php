<?php

namespace Tests\Feature\Api;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ClientLoginTest extends TestCase
{
   use RefreshDatabase;

    public function testAdminCanLoginAndGenerateToken()
    {
        $this->seed(\RoleSeeder::class);
        $user = factory(User::class)->create([
            'role_id' => '1',
            'password' => Hash::make('password123')
            ]);

        $response = $this->postJson(route('api.login'), [
            'login' => $user->email,
            'password' => 'password123'
        ]);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'status',
            'token',
        ]);
        $response->assertJsonFragment([
            'status' => 'OK',
        ]);
    }

    public function testUserNotFound()
    {
        $response = $this->postJson(route('api.login'), [
            'login' => 'example@example.com',
            'password' => 'password888'
        ]);

        $response->assertSuccessful();
        $response->assertExactJson([
            'status' => 'FAILED',
            'reason' => 'User not found'
        ]);
    }

    public function testUserCanNotLoginDueIsBuyer()
    {
        $this->seed(\RoleSeeder::class);
        $user = factory(User::class)->create([
            'role_id' => '3',
            'password' => Hash::make('password123')
        ]);

        $response = $this->postJson(route('api.login'), [
            'login' => $user->email,
            'password' => 'password123'
        ]);

        $response->assertSuccessful();
        $response->assertExactJson([
            'status' => 'FAILED',
            'reason' => 'Access denied'
        ]);
    }

    public function testUserCanNotLoginDueInvalidPassword()
    {
        $this->seed(\RoleSeeder::class);
        $user = factory(User::class)->create([
            'role_id' => '1',
            'password' => Hash::make('password123')
        ]);

        $response = $this->postJson(route('api.login'), [
            'login' => $user->email,
            'password' => 'wrongPassword'
        ]);

        $response->assertSuccessful();
        $response->assertExactJson([
            'status' => 'FAILED',
            'reason' => 'Invalid password'
        ]);
    }


}
