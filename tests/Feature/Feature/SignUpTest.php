<?php

namespace Tests\Feature\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SignUpTest extends TestCase
{
    public function testSignUpSuccessfully()
    {
        $payload = [
            'name' => 'Jhon',
            'email' => 'jhon@test.com',
            'password' => 'asd123.',
            'password_confirmation' => 'asd123.'
        ];

        $this->json('POST', 'api/sign-up', $payload)
            ->assertStatus(201)
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

    public function testRequiresNameEMailAndPassword()
    {
        $this->json('post', 'api/sign-up')
            ->assertStatus(422)
            ->assertJson([
                'name' => ['The name field is required.'],
                'email' => ['The email field is required.'],
                'password' => ['The password field is required.'],
            ]);
    }

    public function testRequirePasswordConfirmation()
    {
        $payload = [
            'name' => 'Jhon',
            'email' => 'jhon@test.com',
            'password' => 'asd123.'
        ];

        $this->json('post', 'api/sign-up', $payload)
            ->assertStatus(422)
            ->assertJson([
                'password' => ['The password confirmation does not match.'],
            ]);
    }
}
