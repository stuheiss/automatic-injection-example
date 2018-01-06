<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FoozipTest extends TestCase
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

    /*
     * Route /zip to Foobarzip@index3
     * Test automatic method injection on Foobarzip@index3
     */
    public function testFoozip()
    {
        $response = $this->get('/zip');

        $response->assertStatus(200);

        $response->assertSee('Hello from baz');
    }
}
