<?php

namespace App\Interfaces;

interface DevelopmentApplicantInterface
{
    public function getAll(?string $search, ?int $limit, bool $excecute);
    public function getAllPaginated(?string $search, ?int $rowPerPage);
    public function getById(string $id);
    public function create(array $data);

    public function update(string $id, array $data);

    public function delete(string $id);
}
