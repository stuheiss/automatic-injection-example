<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Foo;
use App\Repositories\Bar;

class FooTest extends TestCase
{
	public function setup()
	{
		$this->foo = new Foo(new Bar);
	}
    public function testCanGetFoo()
    {
    	$this->assertEquals("App\Repositories\Foo", get_class($this->foo));
    }
    public function testCanGetFoobar()
    {
    	$bar = $this->foo->getBarInstance();
    	$this->assertEquals("App\Repositories\Bar", get_class($bar));
    }
    public function testCanGetFoobarzip()
    {
    	$bar = $this->foo->getBarInstance();
    	$this->assertEquals("foobarzip", $bar->getFoobarzip());
    }
}
