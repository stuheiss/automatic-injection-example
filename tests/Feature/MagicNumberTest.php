<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MagicNumberTest extends TestCase
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

    public function testCanSeeMagic()
    {
        $response = $this->get('/magic');

        $response->assertStatus(200);

        $this->assertRegExp('/\d{1,3}/', $response->getContent());
    }
}
