<?php

namespace App\Repositories;

interface ContactRepositoryInterface
{
    public function getPaginate($nome = null, $cpf = null, $perPage = 5);

    public function createContact(array $data);

    public function getById(string $contactId);

    public function updateContact(array $data, string $contactId);

    public function deleteContact(string $contactId);
}
