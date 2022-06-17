<?php
namespace App\Repositories\Eloquent;
use App\Models\Contact;
use App\Models\Tag;
use App\Repositories\Contracts\RepositoriesInterface;
use App\Repositories\Exceptions\RepositoriesException;
use Illuminate\Support\Facades\DB;

class ContactRepository extends AbstractEloquentRepositories implements RepositoriesInterface
{

    public function __construct(Contact $model = null) {
        $model = $model ?? new Contact();
        $this->model = $model;
        $this->orderBy = "name";
    }
    /**
     * @throws RepositoriesException
     */
    public function findAll()
    {
        $this->with(['tags']);
        return  parent::findAll(); // TODO: Change the autogenerated stub
    }
    public function store(array $data)
    {
        return DB::transaction( function () use ($data) {
            $contact = parent::store($data);
            foreach ($data['tags'] as $tag) {
                $contact->tagInContacts()->create([
                    'tag_id' => $tag
                ]);
            }
            return $contact;
        });

    }
}