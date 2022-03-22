<?php

namespace Tests\Feature\Http\Controllers\Api\v1;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\ApiFeatureTestCase;
use Tests\FeatureTestCase;
use Tests\TestCase;

class ClientControllerTest extends ApiFeatureTestCase
{

    private array $payload = [
        'name' => 'testing',
        'address' => 'rua 1',
        'phone_number' => '555-5555'
    ];
    /** @test */
    public function guest_user_cannot_get_clients_index()
    {
        $this->getJson(route('api.clients.index'))
            ->assertSee('Unauthenticated')
            ->assertStatus(401);
    }

    /** @test */
    public function common_user_cannot_see_listing()
    {
        $this->login();
        $this->getJson(route('api.clients.index'))
            ->assertStatus(403);
    }

    /** @test */
    public function admin_can_see_client_index_listing()
    {
        $this->loginAsAdmin();
        $clients = Client::factory(10)->create();

        $this->getJson(route('api.clients.index'))
            ->assertOk()
            ->assertSee($clients[0]->name);
    }

    /** @test */
    public function admin_can_create_a_client()
    {
        $this->loginAsAdmin();



        $this->postJson(route('api.clients.store'), $this->payload)
            ->assertStatus(201)
            ->assertSee($this->payload['name']);

        $this->assertDatabaseHas('clients', $this->payload);
    }

    /** @test */
    public function missing_fields_on_store_method_should_fail()
    {
        $this->loginAsAdmin();

        $this->postJson(route('api.clients.store'), [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'address', 'phone_number']);
    }

    /** @test */
    public function admin_can_update_client()
    {
        $client = Client::factory()->create();
        $this->loginAsAdmin();

        $this->putJson(
            route('api.clients.update', ['client' => $client->id]),
            $this->payload
        )
            ->assertStatus(201)
            ->assertSee($this->payload['name']);

        $this->assertDatabaseHas('clients', ['name' => $this->payload['name']]);
    }

    /** @test */
    public function admin_gets_error_when_try_to_update_nonexistent_client()
    {
        $this->loginAsAdmin();
        $this->putJson(
            route('api.clients.update', ['client' => 0]),
            $this->payload
        )
            ->assertStatus(404)
            ->assertSee('No query results for model');
    }
    /** @test */
    public function admin_cannot_update_to_a_existing_name()
    {
        $client = Client::factory()->create();
        Client::factory()->create(['name' => 'myname']);
        $this->loginAsAdmin();

        $this->putJson(
            route('api.clients.update', ['client' => $client->id]),
            ['name' => 'myname']
        )
            ->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function admin_deletes_product_sucessfully()
    {
        $this->loginAsAdmin();
        $client = Client::factory()->create();

        $this->assertDatabaseHas('clients', ['name' => $client->name]);

        $this->deleteJson(route('api.clients.destroy', ['client' => $client->id]))
            ->assertStatus(204);

        $this->assertDatabaseMissing('clients', ['name' => $client->name]);
        $this->assertDatabaseCount('clients', 0);
    }

    /** @test */
    public function admin_gets_error_when_try_to_delete_nonexistent_client()
    {
        $this->loginAsAdmin();
        $this->putJson(route('api.clients.destroy', ['client' => 0]))
            ->assertStatus(404)
            ->assertSee('No query results for model');
    }
}
