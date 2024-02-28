<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateContact;
use App\Http\Resources\ContactResource;
use App\Services\ContactService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    private $service;

    public function __construct(ContactService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $nome = $request->input('nome');

        $contacts = $this->service->getPaginate($nome);

        return ContactResource::collection($contacts);
    }

    public function show($contactId)
    {
        $contact = $this->service->getById($contactId);

        if (!$contact) {
            return response()->json(['message' => 'Contato não encontrado.'], 404);
        }

        return new ContactResource($contact);
    }

    public function store(StoreUpdateContact $request)
    {
        $data = $request->validated();

        $newContact = $this->service->createContact($data);

        return response()->json([
            'message' => 'Contato criado com sucesso.',
            'contact' => new ContactResource($newContact),
        ], 201);
    }

    public function update(StoreUpdateContact $request, $contactId)
    {
        $contact = $this->service->updateContact($request->validated(), $contactId);

        return new ContactResource($contact);
    }

    public function destroy($contactId)
    {
        return $this->service->deleteContact($contactId);
    }
}
