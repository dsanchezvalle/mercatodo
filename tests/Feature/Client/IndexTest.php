<?php

namespace Tests\Feature\Client;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanSeeClientIndexView()
    {
        $this->seed(\RoleSeeder::class);
        $user = factory(User::class)->create(['role_id' => '1']);
        $clients = factory(User::class, 10)->create();

        $response = $this->actingAs($user)->get(route('clients.index'));

        $response->assertSuccessful();
        $response->assertViewIs('admin.client.index');
        $response->assertSee($clients->first()->name);
    }

    public function testEditorCanNotSeeClientIndexView()
    {
        $user = factory(User::class)->create(['role_id' => '2']);

        $response = $this->actingAs($user)->get(route('clients.index'));

        $response->assertForbidden();
    }

    public function testBuyerCanNotSeeClientIndexView()
    {
        $user = factory(User::class)->create(['role_id' => '3']);

        $response = $this->actingAs($user)->get(route('clients.index'));

        $response->assertForbidden();
    }

    public function testNonAuthenticatedUserCanNotSeeClientIndexView()
    {
        $this->get(route('clients.index'))->assertRedirect(route('verification.notice'));
    }
}
