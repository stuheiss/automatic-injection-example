<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Bar;

class BarTest extends TestCase
{
    public function setup()
    {
        $this->bar = new Bar;
    }
    public function testCanGetFoobarzip()
    {
        $this->assertEquals("foobarzip", $this->bar->getFoobarzip());
    }
    public function testGetFoobarbazqux()
    {
        $this->assertEquals('foobarbazqux', $this->bar->getFoobarbazqux());
    }
}
