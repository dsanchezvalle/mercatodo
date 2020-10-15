<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @test
     * @return void
     */
    public function admin_can_see_client_index_view()
    {
        $user = factory(User::class)->create(['is_admin' => true]);

        $response = $this->actingAs($user)->get('/clients');

        $response->assertSuccessful();
        $response->assertViewIs('admin.client.index');
    }

    /**
     * A basic feature test example.
     *
     * @test
     * @return void
     */
    public function admin_can_see_client_list()
    {
        $user = factory(User::class)->create(['is_admin' => true]);
        $clients = factory(User::class, 10)->create();

        $response = $this->actingAs($user)->get('/clients');

        $response->assertSee($clients->first()->name);
    }

    /**
     * A basic feature test example.
     *
     * @test
     * @return void
     */
    public function admins_are_not_in_client_list()
    {
        $user = factory(User::class)->create(['is_admin' => true]);

        $response = $this->actingAs($user)->get('/clients');

        $response->assertViewMissing($user->name);
    }

    /**
     * A basic feature test example.
     *
     * @test
     * @return void
     */
    public function non_admins_cannot_see_client_index_view()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/clients');

        $response->assertForbidden();
    }

    /**
     * A basic feature test example.
     *
     * @test
     * @return void
     */
    public function admins_can_see_update_client_view()
    {
        $user = factory(User::class)->create(['is_admin' => true]);
        $client = factory(User::class)->create();

        $response = $this->actingAs($user)->get("/clients/$client->id/edit");

        $response->assertSuccessful();
        $response->assertViewIs('admin.client.edit');
    }

    /**
     * A basic feature test example.
     *
     * @test
     * @return void
     */
    public function admins_can_update_client_info()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create(['is_admin' => true]);
        $client = factory(User::class)->create();

        $response = $this->actingAs($user)->put(
            "/clients/$client->id",
            [
            'name' => 'Many',
            'surname' => 'Delgado',
            'document_type' => 'CC',
            'document_number' => '12345',
            'is_active' => 'on',
            'email' => 'many@hotm.com',
            'phone_number' => '1234546'
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
}
