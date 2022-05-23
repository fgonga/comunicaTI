<?php
namespace App\Repositories\Eloquent;
use App\Models\Contact;
use App\Models\Tag;
use App\Repositories\Contracts\RepositoriesInterface;
use App\Repositories\Exceptions\RepositoriesException;

class TagRepository extends AbstractEloquentRepositories implements RepositoriesInterface
{

    public function __construct(Tag $user = null) {
        if($user == null){
            $user = new Tag();
        }
        $this->model = $user;
        $this->orderBy = "nome";
    }

    /**
     * @throws RepositoriesException
     */
    public function contacts($id){
        return $this->with(["contacts.tags"])->findOneById($id);
    }

}
