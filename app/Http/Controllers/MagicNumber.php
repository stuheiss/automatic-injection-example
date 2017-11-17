<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\RandomRepository;
use App\Repositories\Contracts\RandomRepositoryInterface;

class MagicNumber extends Controller
{
	protected $generator;

	public function __construct(RandomRepositoryInterface $generator)
	{
		$this->generator = $generator;
	}

    public function index()
    {
    	return $this->generator->magic();
    }
}
