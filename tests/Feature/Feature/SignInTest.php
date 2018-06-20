<?php

namespace Tests\Feature\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SignInTest extends TestCase
{
    public function testRequiresEmailAndPassword()
    {
        $this->json('POST', 'api/sign-in')
            ->assertStatus(422)
            ->assertJson([
               'email' => ['The email field is required.'],
               'password' => ['The password field is required.']
            ]);
    }

    public function testUserSignInIncorrect() {
        $user = factory(User::class)->create([
            'email' => 'testsignin@test.com',
            'password' => bcrypt('asd123.')
        ]);

        $payload = [
            'email' => 'atestsignin@test.com',
            'password' => 'wrongpass'
        ];

        $this->json('POST', 'api/sign-in', $payload)
            ->assertStatus(422)
            ->assertJsonStructure([
                'email'
            ])
            ->assertJson([
                'email' => 'These credentials do not match our records.'
            ]);
    }

    public function testUserSignInSuccessfully() {
        $user = factory(User::class)->create([
           'email' => 'testsignin@test.com',
           'password' => bcrypt('asd123.')
        ]);

        $payload = [
            'email' => 'testsignin@test.com',
            'password' => 'asd123.'
        ];

        $this->json('POST', 'api/sign-in', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'api_token'
                ]
            ]);
    }
}
