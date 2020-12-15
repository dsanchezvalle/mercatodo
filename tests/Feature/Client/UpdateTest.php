<?php

namespace Tests\Feature\Client;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanUpdateClientInfo()
    {
        $user = factory(User::class)->create(['role_id' => '1']);
        $client = factory(User::class)->create();

        $response = $this->actingAs($user)->put(
            route('clients.update', $client->id),
            [
                'name' => 'Many',
                'surname' => 'Delgado',
                'document_type' => 'CC',
                'document_number' => '12345',
                'is_active' => 'on',
                'email' => 'many@hotm.com',
                'phone_number' => '1234546',
                'role_id' => '3'
            ]
        );

        $response->assertRedirect(route('clients.index'));
        $expectedData = User::find(2);

        $this->assertEquals('Many', $expectedData->name);
        $this->assertEquals('Delgado', $expectedData->surname);
        $this->assertEquals('CC', $expectedData->document_type);
        $this->assertEquals('12345', $expectedData->document_number);
        $this->assertEquals('many@hotm.com', $expectedData->email);
        $this->assertEquals('1234546', $expectedData->phone_number);
    }

    public function testEditorCanNotUpdateClientInfo()
    {
        $user = factory(User::class)->create(['role_id' => '2']);
        $client = factory(User::class)->create();

        $response = $this->actingAs($user)->put(
            route('clients.update', $client->id),
            [
                'name' => 'Many',
                'surname' => 'Delgado',
                'document_type' => 'CC',
                'document_number' => '12345',
                'is_active' => 'on',
                'email' => 'many@hotm.com',
                'phone_number' => '1234546',
                'role_id' => '3'
            ]
        );

        $response->assertForbidden();
    }

    public function testBuyerCanNotUpdateClientInfo()
    {
        $user = factory(User::class)->create(['role_id' => '3']);
        $client = factory(User::class)->create();

        $response = $this->actingAs($user)->put(
            route('clients.update', $client->id),
            [
                'name' => 'Many',
                'surname' => 'Delgado',
                'document_type' => 'CC',
                'document_number' => '12345',
                'is_active' => 'on',
                'email' => 'many@hotm.com',
                'phone_number' => '1234546',
                'role_id' => '3'
            ]
        );

        $response->assertForbidden();
    }

    public function testNonAuthenticatedUserCanNotUpdateClientInfo()
    {
        $client = factory(User::class)->create();

        $response = $this->put(
            route('clients.update', $client->id),
            [
                'name' => 'Many',
                'surname' => 'Delgado',
                'document_type' => 'CC',
                'document_number' => '12345',
                'is_active' => 'on',
                'email' => 'many@hotm.com',
                'phone_number' => '1234546',
                'role_id' => '3'
            ]
        );

        $response->assertRedirect(route('verification.notice'));
    }
}
