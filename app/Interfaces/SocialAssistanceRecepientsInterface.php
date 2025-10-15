<?php

namespace App\Interfaces;

interface SocialAssistanceRecepientsInterface {
    public function getAll(?string $search, ?int $limit, bool $excecute);

    public function getAllPaginated(?string $search, ?int $rowPerPage);

    public function create(array $data);

    public function show(string $id);

    public function update(string $id, array $data);

    public function delete(string $id);
}
