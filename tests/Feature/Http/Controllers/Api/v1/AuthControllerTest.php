<?php

namespace Tests\Feature\Http\Controllers\Api\v1;

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
}
