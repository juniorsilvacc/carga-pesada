<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateNote;
use App\Http\Resources\NoteResource;
use App\Services\NoteService;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Note",
 *     required={"id", "descricao", "cidade", "estado", "valor", "viagem_id"},
 *
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         format="uuid",
 *         description="ID único do caminhão (UUID)"
 *     ),
 *     @OA\Property(
 *         property="descricao",
 *         type="string",
 *         description="Descrição"
 *     ),
 *     @OA\Property(
 *         property="cidade",
 *         type="string",
 *         description="Cidade"
 *     ),
 *     @OA\Property(
 *         property="estado",
 *         type="string",
 *         description="Estado"
 *     ),
 *     @OA\Property(
 *         property="valor",
 *         type="number",
 *         format="float",
 *         description="Valor"
 *     ),
 *     @OA\Property(
 *         property="viagem_id",
 *         type="string",
 *         format="uuid",
 *         description="ID único da viagem (UUID)"
 *     ),
 * )
 *
 * @OA\Schema(
 *     schema="StoreUpdateNote",
 *     title="StoreUpdateNote",
 *     required={"descricao", "cidade", "estado", "valor", "viagem_id"},
 *
 *     @OA\Property(
 *         property="descricao",
 *         type="string",
 *         description="Descrição"
 *     ),
 *     @OA\Property(
 *         property="cidade",
 *         type="string",
 *         description="Cidade"
 *     ),
 *     @OA\Property(
 *         property="estado",
 *         type="string",
 *         description="Estado"
 *     ),
 *     @OA\Property(
 *         property="valor",
 *         type="number",
 *         format="float",
 *         description="Valor"
 *     ),
 *     @OA\Property(
 *         property="viagem_id",
 *         type="string",
 *         format="uuid",
 *         description="ID único da viagem (UUID)"
 *     ),
 * )
 */
class NoteController extends Controller
{
    private $service;

    public function __construct(NoteService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/notes",
     *     summary="Listar todas as notas",
     *     tags={"Note"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\Parameter(
     *         name="cidade",
     *         in="query",
     *         description="Filtrar por cidade",
     *         required=false,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Lista de notas",
     *
     *         @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(ref="#/components/schemas/Note")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $cidade = $request->input('cidade');

        $notes = $this->service->getPaginate($cidade);

        return NoteResource::collection($notes);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/notes/{id}",
     *     summary="Obter detalhes de uma nota específica",
     *     tags={"Note"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da nota",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes da nota",
     *
     *         @OA\JsonContent(ref="#/components/schemas/Note")
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Nota não encontrada",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Nota não encontrada."
     *             )
     *         )
     *     )
     * )
     */
    public function show($noteId)
    {
        $note = $this->service->getById($noteId);

        if (!$note) {
            return response()->json(['message' => 'Nota não encontrada.'], 404);
        }

        return new NoteResource($note);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/notes",
     *     summary="Criar uma nova nota",
     *     tags={"Note"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados da nova nota",
     *
     *         @OA\JsonContent(ref="#/components/schemas/StoreUpdateNote")
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Nota criada com sucesso",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Nota criada com sucesso."),
     *             @OA\Property(property="note", ref="#/components/schemas/Note")
     *         )
     *     )
     * )
     */
    public function store(StoreUpdateNote $request)
    {
        $data = $request->validated();

        $newNote = $this->service->createNote($data);

        return response()->json([
            'message' => 'Nota criada com sucesso.',
            'note' => new NoteResource($newNote),
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/notes/{id}",
     *     summary="Atualizar uma nota existente",
     *     tags={"Note"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da nota a ser atualizada",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados da nota a ser atualizada",
     *
     *         @OA\JsonContent(ref="#/components/schemas/StoreUpdateNote")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Nota atualizada com sucesso",
     *
     *         @OA\JsonContent(ref="#/components/schemas/Note")
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Nota não encontrada"
     *     )
     * )
     */
    public function update(StoreUpdateNote $request, $noteId)
    {
        $note = $this->service->updateNote($request->validated(), $noteId);

        return new NoteResource($note);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/notes/{id}",
     *     summary="Deletar uma nota existente",
     *     tags={"Note"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da nota a ser deletada",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Nota deletada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Nota não encontrada"
     *     )
     * )
     */
    public function destroy($noteId)
    {
        return $this->service->deleteNote($noteId);
    }
}
