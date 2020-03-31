<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AllRegistrationTest extends TestCase
{
    public function test_page_shown()
    {
        //Arrange
        $values = [
            'Ping pong manager',
            'Register players',
            'First player name',
            'Second player name'];

        //Act
        $response = $this->get(route('registration'));

        //Assert
        $response->assertSeeTextInOrder($values);
        $response->assertStatus(200);
        $response->assertViewIs('registration');
    }
}
