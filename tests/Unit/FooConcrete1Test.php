<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\FooConcrete1;

class FooConcrete1Test extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $foo1 = new FooConcrete1;
        $this->assertEquals('index@FooConcrete1', $foo1->index());
    }
}
