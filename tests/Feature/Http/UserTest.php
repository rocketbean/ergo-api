<?php

namespace Tests\Feature\Http;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Tests\Feature\Http\TestHelper;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use WithFaker, RefreshDatabase, TestHelper;
    public function createUser () {
        return factory(User::class)->create();
    }
    /**
     * A basic feature test example.
     * "./vendor/bin/phpunit" C:/Users/buzzo/OneDrive/Desktop/web/ergo-api/tests/Feature/Http/UserTest
     * @test
     */
    public function can_login()
    {
        $user = $this->createUser();
        $response = $this->post('/api/attempt', [
            'email' => $user->email,
            'password' => 'password'
        ]);
        $response->assertStatus(200);
    }
}
