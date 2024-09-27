<?php

namespace App\Repositories\Interfaces;

use App\Models\Jabatan;
use Illuminate\Http\Request;

interface JabatanRepositoryInterface
{
    public function create(array $data);
    public function get(Request $request);
    public function getById(string $id): ?Jabatan;
    public function update(string $id, array $data): ?Jabatan;
    public function delete(string $id): bool;
}
