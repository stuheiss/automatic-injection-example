<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\RandomRepository;
use App\Repositories\Contracts\RandomRepositoryInterface;

class MagicNumber extends Controller
{
    public function index()
    {
    	return rand(0, 100);
    }
}
