<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AllPingPongTest extends TestCase
{
    public function test_click_end_game()
    {
        //Arrange
        $value = 'Register players';

        //Act then Assert
        $this->visit(route('pingpong'))
            ->click('End Game')
            ->seePageIs(route('registration'))
            ->see($value);
    }

    public function test_page_shown()
    {
        //Arrange
        $notValue = 'Register players';
        $values = [
            'Ping pong manager',
            '0-0',
            'Game started at:',
            'Leaderboard',
            'All Matches'];

        //Act
        $response = $this->get(route('pingpong'));

        //Assert
        $response->assertDontSeeText($notValue);
        $response->assertSeeTextInOrder($values);
        $response->assertOk();
        $response->assertViewIs('pingpong');
    }
}
