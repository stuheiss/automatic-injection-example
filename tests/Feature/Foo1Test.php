<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Foo1Test extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/foo1');

        $response->assertStatus(200);

        $response->assertSee('index@FooConcrete1');
    }
}
