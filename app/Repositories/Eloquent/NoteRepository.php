<?php

namespace App\Repositories\Eloquent;

use App\Models\Note;
use App\Repositories\NoteRepositoryInterface;

class NoteRepository implements NoteRepositoryInterface
{
    private $model;

    public function __construct(Note $note)
    {
        $this->model = $note;
    }

    public function getPaginate($cidade = null, $perPage = 5)
    {
        $query = $this->model->orderBy('created_at', 'asc');

        if ($cidade !== null) {
            $query->where('cidade', 'LIKE', "%{$cidade}%");
        }

        $notes = $query->paginate($perPage);

        return $notes;
    }

    public function createNote(array $data)
    {
        $newNote = $this->model->create($data);

        return $newNote;
    }

    public function getById(string $noteId)
    {
        $note = $this->model->where('id', $noteId)->first();

        return $note;
    }

    public function updateNote(array $data, string $noteId)
    {
        $note = $this->model->findOrFail($noteId);

        $note->update($data);

        return $note;
    }

    public function deleteNote(string $noteId)
    {
        $note = $this->model->where('id', $noteId)->first();

        if (!$note) {
            return response()->json(['message' => 'Nota não encontrada.'], 404);
        }

        $note->delete();
    }
}
