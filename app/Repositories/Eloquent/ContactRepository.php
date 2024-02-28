<?php

namespace App\Repositories\Eloquent;

use App\Models\Contact;
use App\Repositories\ContactRepositoryInterface;

class ContactRepository implements ContactRepositoryInterface
{
    private $model;

    public function __construct(Contact $contact)
    {
        $this->model = $contact;
    }

    public function getPaginate($nome = null, $cpf = null, $perPage = 5)
    {
        $query = $this->model->orderBy('created_at', 'asc');

        if ($nome !== null) {
            $query->where('nome', 'LIKE', "%{$nome}%");
        }

        $contacts = $query->paginate($perPage);

        return $contacts;
    }

    public function createContact(array $data)
    {
        $newContact = $this->model->create($data);

        return $newContact;
    }

    public function getById(string $contactId)
    {
        $contact = $this->model->where('id', $contactId)->first();

        return $contact;
    }

    public function updateContact(array $data, string $contactId)
    {
        $contact = $this->model->findOrFail($contactId);

        $contact->update($data);

        return $contact;
    }

    public function deleteContact(string $contactId)
    {
        $contact = $this->model->where('id', $contactId)->first();

        if (!$contact) {
            return response()->json(['message' => 'Contato não encontrado.'], 404);
        }

        $contact->delete();
    }
}
