<?php


namespace App\Repository;


use App\Entity\User;

interface UserRepositoryInterface
{
    /**
     * @param User $user
     * @return mixed
     */
    public function create(User $user);

    /**
     * @param User $user
     * @return mixed
     */
    public function save(User $user);

    /**
     * @param $userId
     * @return object
     */
    public function getOne($userId): object;

    /**
     * @return array
     */
    public function getAll(): array;
}