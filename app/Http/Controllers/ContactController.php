<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateContact;
use App\Http\Resources\ContactResource;
use App\Services\ContactService;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Contact",
 *     required={"id", "nome", "phone"},
 *
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         format="uuid",
 *         description="ID único do contato (UUID)"
 *     ),
 *     @OA\Property(
 *         property="nome",
 *         type="string",
 *         description="Nome do contato"
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         description="Número de telefone do contato"
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="StoreUpdateContact",
 *     title="StoreUpdateContact",
 *     required={"nome", "phone"},
 *
 *     @OA\Property(
 *         property="nome",
 *         type="string",
 *         description="Nome do contato"
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         description="Número de telefone do contato"
 *     ),
 * )
 */
class ContactController extends Controller
{
    private $service;

    public function __construct(ContactService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/contacts",
     *     summary="Listar todos os contatos",
     *     tags={"Contact"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\Response(
     *         response=200,
     *         description="Lista de contatos",
     *
     *         @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(ref="#/components/schemas/Contact")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $nome = $request->input('nome');

        $contacts = $this->service->getPaginate($nome);

        return ContactResource::collection($contacts);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/contacts/{id}",
     *     summary="Obter detalhes de um contato específico",
     *     tags={"Contact"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do contato",
     *
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do contato",
     *
     *         @OA\JsonContent(ref="#/components/schemas/Contact")
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Contato não encontrado",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Contato não encontrado."
     *             )
     *         )
     *     )
     * )
     */
    public function show($contactId)
    {
        $contact = $this->service->getById($contactId);

        if (!$contact) {
            return response()->json(['message' => 'Contato não encontrado.'], 404);
        }

        return new ContactResource($contact);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/contacts",
     *     summary="Criar um novo contato",
     *     tags={"Contact"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados do novo contato",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 property="nome",
     *                 type="string",
     *                 description="Nome do contato"
     *             ),
     *             @OA\Property(
     *                 property="phone",
     *                 type="string",
     *                 description="Número de telefone do contato"
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Contato criado com sucesso",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Contato criado com sucesso."
     *             ),
     *             @OA\Property(
     *                 property="contact",
     *                 ref="#/components/schemas/Contact"
     *             )
     *         )
     *     )
     * )
     */
    public function store(StoreUpdateContact $request)
    {
        $data = $request->validated();

        $newContact = $this->service->createContact($data);

        return response()->json([
            'message' => 'Contato criado com sucesso.',
            'contact' => new ContactResource($newContact),
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/contacts/{id}",
     *     summary="Atualizar um contato existente",
     *     tags={"Contact"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do contato a ser atualizado",
     *
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados do contato a ser atualizado",
     *
     *         @OA\JsonContent(ref="#/components/schemas/StoreUpdateContact")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Contato atualizado com sucesso",
     *
     *         @OA\JsonContent(ref="#/components/schemas/Contact")
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Contato não encontrado"
     *     )
     * )
     */
    public function update(StoreUpdateContact $request, $contactId)
    {
        $contact = $this->service->updateContact($request->validated(), $contactId);

        return new ContactResource($contact);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/contacts/{id}",
     *     summary="Excluir um contato",
     *     tags={"Contact"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do contato a ser excluído",
     *
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Contato excluído com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Contato não encontrado"
     *     )
     * )
     */
    public function destroy($contactId)
    {
        return $this->service->deleteContact($contactId);
    }
}
