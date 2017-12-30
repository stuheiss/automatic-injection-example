<?php

namespace App\Repositories;

/*
    Foo is a helper class that will be injected into the Foobarzip controller.

    Foo depends on another helper class Bar.

    Bar will be injected into a new instance of Foo by the IoC.
*/
class FooConcrete1 extends FooAbstract
{
    public function index()
    {
        return 'index@FooConcrete1';
    }
}
