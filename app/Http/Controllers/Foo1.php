<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\FooConcrete1;
use App\Repositories\FooAbstract;

/*
	Demo automatic injection by typehinting an abstract class but injecting a concrete implementation. The IoC is able to resolve by using a registered binding in AppServiceProvider.

    FooAbstract is an abstract repository. FooConcrete1 is an implementation of FooAbstract.


	Foo1 is a controller, injected with an instance of FooConcrete1 though the typehint specifies the abstract class FooAbstract.

    AppServiceProvider::register sets the binding using the when/needs/give pattern.
    See AppServiceProvider for details.
*/

class Foo1 extends Controller
{
	protected $foo;

	// typehint the concrete class
    // public function __construct(FooConcrete1 $foo)
    // {
    //     $this->foo = $foo;
    // }

    // typehint the abstract class and register the bind in AppServiceProvider
    public function __construct(FooAbstract $foo)
	{
		$this->foo = $foo;
	}
    /*
     * call index on injected $foo object
     */
    public function index()
    {
    	return $this->foo->index();
    }
}
