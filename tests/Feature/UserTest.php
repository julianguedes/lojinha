<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->postJson('api/users', [
            'name' => 'Julian',
            'email' => 'julianguedesss@mail.com',
            'password' => '12345678',
        ]);

        $response->dump()->assertStatus(201);
        
    }

    public function test_example2()
    {
        $response = $this->postJson('api/products', [
            'name' => 'Laranja',
            'description' => 'Frutas frescas',
            'value' => '10',
        ]);

        $response->dump()->assertStatus(201);
        
    }
}
