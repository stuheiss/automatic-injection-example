<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FoobarzipTest extends TestCase
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

    public function testFoobarzip()
    {
        $response = $this->get('/foo');

        $response->assertStatus(200);

        $response->assertSee('foobarzip');
    }
}
