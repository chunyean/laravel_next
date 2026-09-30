<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_login(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'test@gmail.com',
            'password' => '12345'
        ], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);

        $token = $response->json('token');
        echo $token;
        $response->assertStatus(200);
    }

    // public function test_register(): void
    // {
    //     $response = $this->postJson('/api/register', [
    //         'name' => 'hero1',
    //         'email' => 'hero1@gmail.com',
    //         'password' => '12345678'
    //     ], [
    //         'Accept' => 'application/json',
    //         'Content-Type' => 'application/json'
    //     ]);

    //     $response->assertStatus(201);
    // }

    public function test_show_task(): void
    {
        $token = '94|3T34IcfMaHJKwT6iLFXKfZajnejHcJRG9XmgWRYt22b5232a';

        $response = $this->getJson('/api/todos', [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200);
    }

    public function test_create_task(): void
    {
        $token = '94|3T34IcfMaHJKwT6iLFXKfZajnejHcJRG9XmgWRYt22b5232a';

        $response = $this->postJson('/api/todos', [
            'title' => 'boring book'
        ], 
        [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200);
    }

    public function test_update_task(): void
    {
        $token = '94|3T34IcfMaHJKwT6iLFXKfZajnejHcJRG9XmgWRYt22b5232a';

        $response = $this->patchJson('/api/todos/6', [
            'title' => 'boring book2'
        ], 
        [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200);
    }

    public function test_get_task(): void
    {
        $token = '94|3T34IcfMaHJKwT6iLFXKfZajnejHcJRG9XmgWRYt22b5232a';

        $response = $this->postJson('/api/todos/6', [], 
        [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200);
    }

    public function test_delete_task(): void
    {
        $token = '94|3T34IcfMaHJKwT6iLFXKfZajnejHcJRG9XmgWRYt22b5232a';

        $response = $this->deleteJson('/api/todos/6', [], 
        [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200);
    }
}
