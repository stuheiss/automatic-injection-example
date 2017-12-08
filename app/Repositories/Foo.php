<?php

namespace App\Repositories;

/*
    Foo is a helper class that will be injected into the Foobarzip controller.

    Foo depends on another helper class Bar.

    Bar will be injected into a new instance of Foo by the IoC.
*/
class Foo
{
    protected $bar;
    public function __construct(Bar $bar)
    {
        $this->bar = $bar;
    }
    public function getBarInstance()
    {
        //return new Bar;
        return $this->bar;
    }
    public function getFoobarbazquxFromBar()
    {
        return $this->bar->getFoobarbazqux();
    }
}
