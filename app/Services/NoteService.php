<?php

namespace App\Services;

use App\Repositories\NoteRepositoryInterface;

class NoteService
{
    private $repository;

    public function __construct(NoteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getPaginate($cidade = null)
    {
        $notes = $this->repository->getPaginate($cidade);

        return $notes;
    }

    public function getById($noteId)
    {
        $note = $this->repository->getById($noteId);

        return $note;
    }

    public function createNote(array $data)
    {
        $newNote = $this->repository->createNote($data);

        return $newNote;
    }

    public function updateNote(array $data, string $noteId)
    {
        $note = $this->repository->updateNote($data, $noteId);

        return $note;
    }

    public function deleteNote(string $noteId)
    {
        return $this->repository->deleteNote($noteId);
    }
}
