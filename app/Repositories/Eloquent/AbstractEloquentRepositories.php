<?php
/*
 * Copyright (c) 2021. por Datalog, Lda Todos os direitos reservados.
 *  Nenhuma parte deste programa pode ser reproduzida, distribuída ou transmitida de qualquer forma ou por qualquer meio, incluindo fotocópia,
 * gravação ou outros métodos eletrônicos ou mecânicos, sem a permissão prévia por escrito da  Datalog, Lda , exceto no caso de breves
 * citações incorporadas em análises críticas e outros usos não comerciais permitidos pela lei de direitos autorais.
 */

namespace App\Repositories\Eloquent;
use App\Repositories\Contracts\RepositoriesInterface;
use App\Repositories\Exceptions\InvalidDataProvidedException;
use App\Repositories\Exceptions\RepositoriesException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

abstract class AbstractEloquentRepositories implements RepositoriesInterface {

	public  $model;
	protected $query;

	/**
	 * @var array $data
	 * query parameters (sort, filters, pagination)
	 */
	protected $data;
	protected $with = [];
	protected $columns = ['*'];
	protected $orderBy;
	protected $sortMethod = 'DESC';
	protected $limit = 300;
	protected $offset = 0;

	public function __construct() {
		$this->orderBy = $this->model->getKeyName();
	}

	public function when(string $name,array $data){
		if(array_key_exists($name, $data)){
			if ($data[$name] !== null) {
				return true;
			}
		}
		return false;
	}
	public function findFirst(){
		return $this->makeQuery()->first($this->columns);
	}

	public function update($date){
		if (is_array($date) === false) {
			throw new RepositoriesException('');
		}
		return $this->model->update($date);
	}
	public function delete(){
		return $this->model->delete();

	}
	/**
	 * @param array $with
	 * @return $this
	 * @throws RepositoriesException
	 */
	public function with(array $with = []) {
		if (is_array($with) === false) {
			throw new RepositoriesException('');
		}

		$this->with = $with;

		return $this;
	}

	/**
	 * @param array $columns
	 * @return $this
	 * @throws RepositoriesException
	 */
	public function columns(array $columns = ['*']) {
		if (is_array($columns) === false) {
			throw new RepositoriesException('');
		}

		$this->columns = $columns;

		return $this;
	}

	/**
	 * @param int $limit
	 * @return $this
	 * @throws RepositoriesException
	 */
	public function limit($limit = 10) {
		if (!is_numeric($limit) || $limit < 1) {
			throw new RepositoriesException('Limit Must be greater than 1');
		}

		$this->limit = $limit;

		return $this;
	}

	/**
	 * @param $id
	 * @param $field
	 */
	public function inc($id, $field) {
		$this->model->findOrFail($id)->increment($field);
	}

	/**
	 * @param $id
	 * @param $field
	 */
	public function dec($id, $field) {
		$this->model->find($id)->decrement($field);
	}

	/**
	 * @param int $offset
	 * @return $this
	 * @throws RepositoriesException
	 */
	public function offset($offset = 0) {
		if (!is_numeric($offset) || $offset < 0) {
			throw new RepositoriesException('Offset must be grater than or equal to ZERO');
		}

		$this->offset = $offset;

		return $this;
	}

	/**
	 * @param $orderBy
	 * @param string $sort
	 * @return $this
	 * @throws RepositoriesException
	 */
	public function orderBy($orderBy = null, $sort = 'ASC') {
		if ($orderBy === null) {
			return $this;
		}

		$this->orderBy = $orderBy;

		if (!in_array(strtoupper($sort), ['DESC', 'ASC'])) {
			throw new RepositoriesException('');
		}

		$this->sortMethod = $sort;

		return $this;
	}

	public function makeQuery() {

		return $this->model;
	}

	/**
	 * @param array $data
	 * @return mixed
	 */
	public function create() {
		return [];
	}

	/**
	 * @param array $data
	 * @return mixed
	 */
	public function store(array $data) {
		return $this->model->create($data);
	}

	public function findById($id) {
		$model = $this->model->where("id", "=", $id)->get()->first();
		if ($model != null) {
			return $model;
		}
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public function findOneById($id) {

		return $this->makeQuery()
		->with($this->with)
		->findOrFail($id, $this->columns);
	}

	/**
	 * @param array $ids
	 * @return mixed
	 */
	public function findManyByIds(array $ids) {
		return $this->makeQuery()
		->with($this->with)
		->orderBy($this->orderBy, $this->sortMethod)
		->whereIn($this->model->getKeyName(), $ids)
		->take($this->limit)
		->skip($this->offset)
		->get($this->columns);
	}

	/**
	 * @param $key
	 * @param $value
	 * @return mixed
	 */
	public function findOneBy($key, $value) {
		return $this->makeQuery()
		->with($this->with)
		->where($key, '=', $value)
		->firstOrFail($this->columns);
	}

	/**
	 * @param $key
	 * @param $value
	 * @return mixed
	 */
	public function findOneByNotRaiseException($key, $value) {
		return $this->makeQuery()
		->with($this->with)
		->where($key, '=', $value)
		->first($this->columns);
	}

	/**
	 * @param $key
	 * @param $value
	 * @return Collection
	 */
	public function findManyBy($key, $value) {
		return $this->makeQuery()
		->with($this->with)
		->where($key, '=', $value)
		->orderBy($this->orderBy, $this->sortMethod)
		->take($this->limit)
		->skip($this->offset)
		->get($this->columns);
	}

	/**
	 * @return Collection
	 */
	public function findAll() {
		return $this->makeQuery()
		->with($this->with)
		->orderBy($this->orderBy, $this->sortMethod)
		->get($this->columns);
	}

	/**
	 * @return Collection
	 */
	public function findMany() {
		return $this->makeQuery()
		->with($this->with)
		->orderBy($this->orderBy, $this->sortMethod)
		->take($this->limit)
		->skip($this->offset)
		->get($this->columns);
	}

	/**
	 * @param array $credentials
	 * @return Collection
	 */
	public function findManyByCredentials(array $credentials = []) {
		return $this->buildCredentialsQuery($credentials)
		->with($this->with)
		->orderBy($this->orderBy, $this->sortMethod)
		->take($this->limit)
		->skip($this->offset)
		->get($this->columns);
	}

	/**
	 * @param array $credentials
	 * @return Collection | ModelNotFoundException
	 */
	public function findOneByCredentials(array $credentials = []) {
		return $this->buildCredentialsQuery($credentials)
		->with($this->with)
		->firstOrFail($this->columns);
	}

	/**
	 * @param $key
	 * @param $value
	 * @param int $perPage
	 * @return mixed
	 */
	public function paginateBy($key, $value, $perPage = 10) {
		return $this->makeQuery()
		->with($this->with)
		->where($key, '=', $value)
		->orderBy($this->orderBy, $this->sortMethod)
		->paginate($perPage, $this->columns);
	}

	/**
	 * @param int $perPage
	 * @return mixed
	 */
	public function paginate($perPage = 10) {

		return $this->makeQuery()
		->with($this->with)
		->orderBy($this->orderBy, $this->sortMethod)
		->paginate($perPage, $this->columns);
	}

	/**
	 * @param $query
	 * @param int $perPage
	 * @return mixed
	 */
	public function paginateQuery($query, $perPage = 10) {
		return $query->orderBy($this->orderBy, $this->sortMethod)
		->paginate($perPage, $this->columns);
	}

	/**
	 * @param $credentials
	 * @param int $perPage
	 * @return Paginator
	 */
	public function paginateByCredentials($credentials, $perPage = 10) {
		return $this->buildCredentialsQuery($credentials)
		->with($this->with)
		->orderBy($this->orderBy, $this->sortMethod)
		->paginate($perPage, $this->columns);
	}

	/**
	 * @param $id
	 * @param array $data
	 * @return bool
	 * @throws InvalidDataProvidedException
	 */
	public function updateOneById($id, array $data = []) {
		if (!is_array($data) || empty($data))
			throw new InvalidDataProvidedException;

		return $this->makeQuery()
		->findOrFail($id)
		->update($data);
	}

	/**
	 * @param $key
	 * @param $value
	 * @param array $data
	 * @return bool
	 * @throws InvalidDataProvidedException
	 */
	public function updateOneBy($key, $value, array $data = []) {
		if (is_array($data) || empty($data))
			throw new InvalidDataProvidedException;

		return $this->makeQuery()
		->where($key, '=', $value)
		->firstOrFail()
		->update($data);
	}

	/**
	 * @param array $credentials
	 * @param array $data
	 * @return bool
	 * @throws InvalidDataProvidedException
	 */
	public function updateOneByCredentials(array $credentials, array $data = []) {
		if (is_array($data) || empty($data))
			throw new InvalidDataProvidedException;

		return $this->buildCredentialsQuery($credentials)
		->firstOrFail()
		->update($data);
	}

	/**
	 * @param $key
	 * @param $value
	 * @param array $data
	 * @return bool
	 * @throws InvalidDataProvidedException
	 */
	public function updateManyBy($key, $value, array $data = []) {

		if (is_array($data) || empty($data)){
			throw new InvalidDataProvidedException;
		}

		return $this->makeQuery()
		->where($key, $value)
		->take($this->limit)
		->skip($this->offset)
		->update($data);
	}

	/**
	 * @param array $ids
	 * @param array $data
	 * @return bool
	 * @throws InvalidDataProvidedException
	 */
	public function updateManyByIds(array $ids, array $data = []) {
		if (!is_array($data) || empty($data))
			throw new InvalidDataProvidedException;

		return $this->makeQuery()
		->whereIn('id', $ids)
		->update($data);
	}

	/**
	 * @param array $ids
	 * @return bool
	 */
	public function allExist(array $ids) {
		return (count($ids) == $this->makeQuery()->whereIn('id', $ids)->count());
	}

	/**
	 * @param array $credentials
	 * @param array $data
	 * @return boolean
	 */
	public function updateManyByCredentials(array $credentials = [], array $data = []) {
		return $this->buildCredentialsQuery($credentials)->update($data);
	}

	/**
	 * @param array $credentials
	 * @param array $data
	 * @return mixed
	 */
	public function updateAllByCredentials(array $credentials = [], array $data = []) {
		return $this->buildCredentialsQuery($credentials)
		->update($data);
	}

	/**
	 * @param $id
	 * @return boolean
	 */
	public function deleteOneById($id) {
		return $this->makeQuery()
		->findOrFail($id)
		->delete();
	}

	/**
	 * @param $key
	 * @param $value
	 * @return boolean
	 */
	public function deleteOneBy($key, $value) {
		return $this->makeQuery()
		->where($key, '=', $value)
		->firstOrFail()
		->delete();
	}

	/**
	 * @param array $credentials
	 * @return boolean
	 */
	public function deleteOneByCredentials(array $credentials = []) {
		return $this->buildCredentialsQuery($credentials)
		->firstOrFail()
		->delete();
	}

	/**
	 * @param $key
	 * @param $value
	 * @return boolean
	 */
	public function deleteManyBy($key, $value) {
		return $this->makeQuery()
		->where($key, $value)
		->take($this->limit)
		->skip($this->offset)
		->delete();
	}

	/**
	 * @param array $credentials
	 * @return boolean
	 */
	public function deleteManyByCredentials(array $credentials = []) {
		return $this->buildCredentialsQuery($credentials)
		->take($this->limit)
		->skip($this->offset)
		->delete();
	}

	/**
	 * @return mixed
	 */
	public function deleteMany() {
		return $this->makeQuery()
		->take($this->limit)
		->delete();
	}

	/**
	 * @param array $ids
	 * @return mixed
	 */
	public function deleteManyByIds(array $ids) {
		return $this->makeQuery()
		->whereIn('id', $ids)
		->delete();
	}

	/**
	 * @return bool|null
	 * @throws \Exception
	 */
	public function deleteAll() {
		return $this->makeQuery()
		->delete();
	}

	/**
	 * @param $credentials
	 * @return bool|null
	 * @throws \Exception
	 */
	public function deleteAllByCredentials($credentials) {
		return $this->buildCredentialsQuery($credentials)
		->delete();
	}

	/**
	 * @param array $credentials
	 * @param int $perPage
	 *
	 *
	 * samples :
	 * categories:in_relation:we|wed|wef|edf
	 * mobile:in:123|23|23|234
	 * name:=:majid
	 * age:<:20
	 * age:>:10
	 * family:like:%asghar%
	 *
	 * @return mixed
	 * @throws RepositoriesException
	 */
	public function searchByCredentials(array $credentials = [], $perPage = 10) {
		$items = [];

		foreach ($credentials as $key => $value) {

			if (!is_array($value)) {
				throw new RepositoriesException();
			}
			$items[] = ['key' => $key, 'operator' => $value[1], 'value' => $value[0]];
		}
		$result = $this->model;
		foreach ($items as $item) {

			if (count($relation = explode('.', $item['key'])) === 2) {
				$result = $result->whereHas($relation[0], function ($query) use ($relation, $item) {
					$query->where($relation[1], $item['operator'], $item['value']);
				});
			} elseif ($item['operator'] == 'in') {
				$result = $result->whereIn($item['key'], explode('|', $item['value']));
			} elseif ($item['operator'] == 'in_relation') {
				$result = $result->whereHas($item['key'], function($q) use ($item) {
					$q->whereIn(str_singular($item['key']) . '_id', explode('|', $item['value']));
				});
			} else {
				$result = $result->Where($item['key'], $item['operator'], $item['value']);
			}
		}

		return $result->with($this->with)->orderBy($this->orderBy, $this->sortMethod)->paginate($perPage, $this->columns);
	}

	/**
	 * @param array $data
	 * @return Model
	 */
	public function add(array $data) {
		$item = $this->model;
		foreach ($data as $k => $v)
			$item->{$k} = $v;

		if (array_key_exists('slug', $data))
			$item->slug = slugify(array_key_exists('name', $data) ? $data['name'] : $data['title']);

		$item->save();

		return $item;
	}



}
