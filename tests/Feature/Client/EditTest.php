<?php

namespace Tests\Feature\Client;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanSeeEditClientInfo()
    {
        $user = factory(User::class)->create(['role_id' => '1']);
        $client = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('clients.edit', $client->id));

        $response->assertSuccessful();
        $response->assertViewIs('admin.client.edit');
    }

    public function testEditorCanNotSeeEditClientInfo()
    {
        $user = factory(User::class)->create(['role_id' => '2']);
        $client = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('clients.edit', $client->id));

        $response->assertForbidden();
    }

    public function testBuyerCanNotSeeEditClientInfo()
    {
        $user = factory(User::class)->create(['role_id' => '3']);
        $client = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('clients.edit', $client->id));

        $response->assertForbidden();
    }

    public function testNonAuthenticatedUserCanNotSeeEditClientInfo()
    {
        $client = factory(User::class)->create();

        $this->get(route('clients.edit', $client->id))->assertRedirect(route('verification.notice'));
    }
}
