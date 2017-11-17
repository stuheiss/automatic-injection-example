<?php

namespace App\Repositories;

class RandomRepository
{
	public function magic()
	{
		return rand(0, 100);
	}
}