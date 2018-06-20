<?php

namespace Tests\Feature\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SignOutTest extends TestCase
{
    public function testUserSignedOutProperly()
    {
        $user = factory(User::class)->create([
            'email' => 'test@test.com'
        ]);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('get', 'api/rooms', [], $headers)->assertStatus(200);
        $this->json('post', 'api/sign-out', [], $headers)->assertStatus(200);

        $user = User::find($user->id);

        $this->assertEquals(null, $user->api_token);
    }

    public function testUserWithNullToken() {
        $user = factory(User::class)->create([
            'email' => 'test@test.com'
        ]);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $user->api_token = null;
        $user->save();

        $this->json('get', 'api/rooms', [], $headers)->assertStatus(401);
    }
}
