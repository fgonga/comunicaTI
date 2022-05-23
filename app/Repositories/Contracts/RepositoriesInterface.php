<?php
/*
 * Copyright (c) 2021. por Datalog, Lda Todos os direitos reservados.
 *  Nenhuma parte deste programa pode ser reproduzida, distribuída ou transmitida de qualquer forma ou por qualquer meio, incluindo fotocópia,
 * gravação ou outros métodos eletrônicos ou mecânicos, sem a permissão prévia por escrito da  Datalog, Lda , exceto no caso de breves
 * citações incorporadas em análises críticas e outros usos não comerciais permitidos pela lei de direitos autorais.
 */

namespace App\Repositories\Contracts;
interface  RepositoriesInterface
{



    /**
     *
     * @return $this
     */
    public function findFirst();


    /**
     * @param array $with
     * @return $this
     */
    public function with(array $with = []);

    /**
     * @param array $columns
     * @return $this
     */
    public function columns(array $columns = ['*']);

    /**
     * @param int $limit
     * @return $this
     */
    public function limit($limit = 10);

    /**
     * @param $orderBy
     * @param string $sort
     * @return $this
     */
    public function orderBy($orderBy, $sort = 'DESC');

    /**
     * @param array $data
     * @return mixed
     */
    public function create();
    /**
     * @param array $data
     * @return mixed
     */
    public  function findById($id);

    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data);

    /**
     * @param $id
     * @return mixed
     */
    public function findOneById($id);

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function findOneBy($key, $value);

    /**
     * @param $key
     * @param $value
     * @return Collection
     */
    public function findManyBy($key, $value);


    /**
     * @param array $ids
     * @return mixed
     */
    public function findManyByIds(array $ids);

    /**
     * @return Collection
     */
    public function findAll();

    /**
     * @param array $credentials
     * @return Collection
     */
    public function findManyByCredentials(array $credentials = []);

    /**
     * @param $key
     * @param $value
     * @param int $perPage
     * @return mixed
     */
    public function paginateBy($key, $value, $perPage = 10);

    /**
     * @param int $perPage
     * @return mixed
     */
    public function paginate($perPage = 10);

    /**
     * @param $credentials
     * @param int $perPage
     * @return Paginator
     */
    public function paginateByCredentials($credentials, $perPage = 10);

    /**
     * @param $id
     * @param array $data
     * @return boolean
     */
    public function updateOneById($id, array $data = []);

    /**
     * @param $key
     * @param $value
     * @param array $data
     * @return boolean
     */
    public function updateOneBy($key, $value, array $data = []);

    /**
     * @param array $credentials
     * @param array $data
     * @return boolean
     */
    public function updateOneByCredentials(array $credentials, array $data = []);

    /**
     * @param $key
     * @param $value
     * @param array $data
     * @return boolean
     */
    public function updateManyBy($key, $value, array $data = []);

    /**
     * @param array $credentials
     * @param array $data
     * @return boolean
     */
    public function updateManyByCredentials(array $credentials = [], array $data = []);


    /**
     * @param array $ids
     * @param array $data
     * @return bool
     */
    public function updateManyByIds(array $ids, array $data = []);

    /**
     * @param $id
     * @return boolean
     */
    public function deleteOneById($id);


    /**
     * @param array $ids
     * @return bool
     */
    public function allExist(array $ids);
    /**
     * @param $key
     * @param $value
     * @return boolean
     */
    public function deleteOneBy($key, $value);

    /**
     * @param array $credentials
     * @return boolean
     */
    public function deleteOneByCredentials(array $credentials = []);

    /**
     * @param $key
     * @param $value
     * @return boolean
     */
    public function deleteManyBy($key, $value);

    /**
     * @param array $credentials
     * @return boolean
     */
    public function deleteManyByCredentials(array $credentials = []);

    /**
     * @param array $credentials
     * @param       $perPage
     *
     * @return mixed
     */
    public function searchByCredentials(array $credentials = [], $perPage);


    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteManyByIds(array $ids);

    /**
     * @param array $data
     * @return mixed
     */
    public function add(array $data);

    /**
     * @param $id
     * @param $field
     */
    public function inc($id, $field);
    /**
     * @param $id
     * @param $field
     */
    public function dec($id, $field);


}
