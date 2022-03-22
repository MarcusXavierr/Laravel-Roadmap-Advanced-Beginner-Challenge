<?php

namespace Tests\Feature\Http\Controllers\Api\v1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\ApiFeatureTestCase;
use Tests\TestCase;

class AuthControllerTest extends ApiFeatureTestCase
{

    /** @test */
    public function user_can_register()
    {
        $payload = [
            'name' => 'Marcus',
            'email' => 'marcus.xavier@aluno.ufop.edu.br',
            'password' => 'password',
        ];
        $this->postJson(route('api.register'), $payload)
            ->assertStatus(201)
            ->assertSeeText('token');

        $this->assertDatabaseHas('users', ['name' => $payload['name'], 'email' => $payload['email']]);
    }

    /** @test */
    public function user_gets_error_message_when_not_validate_request()
    {
        $this->postJson(route('api.register'), [])
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }


    /** @test */
    public function user_can_log_in()
    {

        User::factory()->create(['email' => 'admin@admin.com', 'password' => Hash::make('testing')]);
        $this->postJson(
            route('api.login'),
            ['email' => 'admin@admin.com', 'password' => 'testing']
        )
            ->assertStatus(201)
            ->assertSeeText('token');
    }

    /** @test */
    public function user_gets_error_when_try_to_login_without_required_fields()
    {
        $this->postJson(route('api.login'), [])
            ->assertJsonValidationErrors(['email', 'password']);
    }

    /** @test */
    public function user_cannot_login_with_wrong_password()
    {
        User::factory()->create(['email' => 'admin@admin.com', 'password' => Hash::make('testing')]);
        $this->postJson(
            route('api.login'),
            ['email' => 'admin@admin.com', 'password' => 'wrongpassword']
        )
            ->assertStatus(401)
            ->assertSee('bad credentials');
    }
}
