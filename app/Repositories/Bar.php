<?php

namespace App\Repositories;

/*
    Bar is a helper class that Foo depends on.
*/
class Bar
{
    public function getFoobarzip()
    {
        return "foobarzip";
    }
    public function getFoobarbazqux()
    {
        return "foobarbazqux";
    }
}
