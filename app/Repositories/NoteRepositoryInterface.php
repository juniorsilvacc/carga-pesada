<?php

namespace App\Repositories;

interface NoteRepositoryInterface
{
    public function getPaginate($cidade = null, $perPage = 5);

    public function createNote(array $data);

    public function getById(string $noteId);

    public function updateNote(array $data, string $noteId);

    public function deleteNote(string $noteId);
}
