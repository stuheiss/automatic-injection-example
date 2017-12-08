<?php

namespace App\Repositories;

use App\Repositories\Contracts\RandomRepositoryInterface;

class RandomRepository implements RandomRepositoryInterface
{
    public function magic()
    {
        return rand(0, 100);
    }
}
