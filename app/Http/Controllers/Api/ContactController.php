<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\RepositoryController;
use App\Http\Requests\ContactStoreRequest;
use App\Http\Requests\TagStoreRequest;
use App\Repositories\Eloquent\ContactRepository;
use App\Repositories\Exceptions\InvalidDataProvidedException;
use App\Repositories\Exceptions\RepositoriesException;
use Illuminate\Http\Request;

class ContactController extends RepositoryController
{

    public function __construct(ContactRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws RepositoriesException
     */
    public function index()
    {
        return response()->json($this->repository->findAll());
    }

    public function store(ContactStoreRequest $request)
    {
        return response()->json($this->repository->store($request->input()));
    }

    public function show($id){
        return response()->json($this->repository->findOneById($id));
    }

    /**
     * @throws InvalidDataProvidedException
     */
    public function update(Request $request, $id)
    {
        return response()->json($this->repository->updateOneById($id,$request->input()));
    }

    public function destroy($id)
    {
        return response()->json($this->repository->deleteOneById($id));
    }

}
