<?php

namespace App\Repositories\Interfaces;

use App\Models\GrupPegawai;

interface GrupPegawaiRepositoryInterface
{
    public function create(array $data): GrupPegawai;
    public function get(): array;
    public function getById(string $id): ?GrupPegawai;
    public function update(string $id, array $data): ?GrupPegawai;
    public function delete(string $id): bool;
}
