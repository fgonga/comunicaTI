<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\RepositoryController;
use App\Http\Requests\TagStoreRequest;
use App\Repositories\Eloquent\TagRepository;
use Illuminate\Http\Request;

class TagController extends RepositoryController
{

    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return response()->json($this->repository->findAll());
    }

    public function store(TagStoreRequest $request)
    {
        return response()->json($this->repository->store($request->input()));
    }

    public function show($id){
        return response()->json($this->repository->findOneById($id));
    }

    public function update(Request $request,$id)
    {
        return response()->json($this->repository->updateOneById($id,$request->input()));
    }

    public function destroy($id)
    {
        return response()->json($this->repository->deleteOneById($id));
    }
    public function contacts(int $id)
    {
        return response()->json($this->repository->contacts($id));
    }

}
