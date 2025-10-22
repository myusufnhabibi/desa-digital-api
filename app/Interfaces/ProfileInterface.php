<?php

namespace App\Interfaces;

interface ProfileInterface {
    public function get();

    public function create(array $data);

    public function update(array $data);
}
