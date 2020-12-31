<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $response = $this->post('/api/record')
            ->assertStatus(200);
    }
}
