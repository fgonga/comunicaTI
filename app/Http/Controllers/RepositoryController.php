<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\RepositoriesInterface;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class RepositoryController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $repository;
    public function __construct(RepositoriesInterface $repository)
    {
        $this->repository = $repository;
    }

}
