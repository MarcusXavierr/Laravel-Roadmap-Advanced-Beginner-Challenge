<?php

namespace Tests\Feature\Admin;

use App\Http\Controllers\Admin\ClientController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\FeatureTestCase;
use Tests\TestCase;

class ClientControllerTest extends FeatureTestCase
{

    //Testing middleware
    /** @test */
    public function guest_cannot_see_clients_index_page()
    {
        $this->get(action([ClientController::class, 'index']))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function common_user_cannot_see_clients_index_page()
    {
        $this->login();
        $this->get(action([ClientController::class, 'index']))
            ->assertStatus(403);
    }

    /** @test */
    public function admin_can_see_clients_index_page()
    {
        $user = User::factory()->create(['is_admin' => true]);
        $this->login($user);
        $this->get(action([ClientController::class, 'index']))
            ->assertStatus(200);
    }
}
