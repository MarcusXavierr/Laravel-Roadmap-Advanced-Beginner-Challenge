<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeatureTestCase extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }


    public function login(User $user = null): User
    {
        $user ??= User::factory()->create();
        $this->actingAs($user);
        return $user;
    }

    public function loginAsAdmin(User $user = null): User
    {
        $user ??= User::factory()->create(['is_admin' => true]);
        $this->actingAs($user);
        return $user;
    }
}
