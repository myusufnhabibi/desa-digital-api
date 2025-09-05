<?php

namespace App\Interfaces;

interface HeadOfFamilyInterface {
    public function getAll(?string $search, ?int $limit, bool $excecute);

    public function getAllPaginated(?string $search, ?int $rowPerPage);

    public function create(array $data);
}
