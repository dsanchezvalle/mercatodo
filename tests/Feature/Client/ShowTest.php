<?php

namespace Tests\Feature\Client;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanSeeShowClientView()
    {
        $user = factory(User::class)->create(['role_id' => '1']);
        $client = factory(User::class)->create(['email' => 'carl@example.com']);

        $response = $this->actingAs($user)->get(route('clients.show', $client->id));

        $response->assertSuccessful();
        $response->assertViewIs('admin.client.show');
        $response->assertSeeText('carl@example.com');
    }

    public function testEditorCanNotSeeShowClientView()
    {
        $user = factory(User::class)->create(['role_id' => '2']);
        $client = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('clients.show', $client->id));

        $response->assertForbidden();
    }

    public function testBuyerCanNotSeeShowClientView()
    {
        $user = factory(User::class)->create(['role_id' => '3']);
        $client = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('clients.show', $client->id));

        $response->assertForbidden();
    }

    public function testNonAuthenticatedUserCanNotShowClients()
    {
        $client = factory(User::class)->create();

        $this->get(route('clients.show', $client->id))->assertRedirect(route('verification.notice'));
    }
}
