<?php

namespace App\Contracts;

interface UserRepositoryInterface
{
    public function getAllUsers();

    public function getUserById($id);

    public function createUser(array $data);

    public function updateUser($id, array $data);

    public function deleteUser($id);
}
