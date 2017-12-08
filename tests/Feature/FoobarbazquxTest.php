<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FoobarbazquxTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testFoobarbazqux()
    {
        $response = $this->get('/baz');

        $response->assertStatus(200);

        $response->assertSee('foobarbazqux');
    }
}
