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
    /** @test */
    public function guest_user_cannot_get_clients_index()
    {
        $this->get(route('api.clients.index'))
            ->assertSee('Unauthenticated')
            ->assertStatus(401);
    }

    /** @test */
    public function common_user_cannot_see_listing()
    {
        $this->login();
        $this->get(route('api.clients.index'))
            ->assertStatus(403);
    }

    /** @test */
    public function admin_can_see_client_index_listing()
    {
        $user = User::factory()->create(['is_admin' => true]);
        $this->login($user);
        $clients = Client::factory(10)->create();

        $this->get(route('api.clients.index'))
            ->assertOk()
            ->assertSee($clients[0]->name);
    }
}
