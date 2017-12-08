<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Foo;

/*
	Demo multiple automatic injection. All injected dependencies are resolved by type hinting. Laravel's IoC uses reflection to figure out what concrete class instance to inject given a type hint.

	Bar is a helper class with method getFoobarzip() that returns "foobarzip."

	Foo is a helper class, injected with Bar, with method getBarInstance() that returns the Bar instance.

	Foobarzip is a controller, injected with Foo, with method index() that returns "foobarzip" by
	first getting the Bar instance from Foo's getBarInstance() method, then invoking Bar's getFoobarzip() method.

	Any number of arbitrary classes can be strung together with injected dependencies.
*/

class Foobarzip extends Controller
{
	protected $foo;
	public function __construct(Foo $foo)
	{
		$this->foo = $foo;
	}
    /*
     * get a Bar instance from Foo and return result of a method call on Bar
     */
    public function index()
    {
    	// expect "foobarzip"
    	return $this->foo->getBarInstance()->getFoobarzip();
    }
    /*
     * get result of method call on Foo that returns result of a method call on Bar
     */
    public function index2()
    {
        // expect "foobarbazqux"
    	return $this->foo->getFoobarbazquxFromBar();
    }
}
