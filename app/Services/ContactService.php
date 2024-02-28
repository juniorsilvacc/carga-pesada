<?php

namespace App\Services;

use App\Repositories\ContactRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ContactService
{
    private $repository;

    public function __construct(ContactRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function createContact(array $data)
    {
        $user = Auth::user();

        $data['user_id'] = $user->id;

        $newContact = $this->repository->createContact($data);

        return $newContact;
    }

    public function getPaginate($nome = null, $cpf = null)
    {
        $contacts = $this->repository->getPaginate($nome, $cpf);

        return $contacts;
    }

    public function getById($contactsId)
    {
        $contacts = $this->repository->getById($contactsId);

        return $contacts;
    }

    public function updateContact(array $data, string $contactId)
    {
        $contact = $this->repository->updateContact($data, $contactId);

        return $contact;
    }

    public function deleteContact(string $contactId)
    {
        return $this->repository->deleteContact($contactId);
    }
}
