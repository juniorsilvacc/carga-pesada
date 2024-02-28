<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateNote;
use App\Http\Resources\NoteResource;
use App\Services\NoteService;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    private $service;

    public function __construct(NoteService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $cidade = $request->input('cidade');

        $notes = $this->service->getPaginate($cidade);

        return NoteResource::collection($notes);
    }

    public function show($noteId)
    {
        $note = $this->service->getById($noteId);

        if (!$note) {
            return response()->json(['message' => 'Nota não encontrada.'], 404);
        }

        return new NoteResource($note);
    }

    public function store(StoreUpdateNote $request)
    {
        $data = $request->validated();

        $newNote = $this->service->createNote($data);

        return response()->json([
            'message' => 'Nota criada com sucesso.',
            'note' => new NoteResource($newNote),
        ], 201);
    }

    public function update(StoreUpdateNote $request, $noteId)
    {
        $note = $this->service->updateNote($request->validated(), $noteId);

        return new NoteResource($note);
    }

    public function destroy($noteId)
    {
        return $this->service->deleteNote($noteId);
    }
}
