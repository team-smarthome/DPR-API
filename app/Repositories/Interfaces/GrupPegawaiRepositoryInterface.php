<?php

namespace App\Repositories\Interfaces;

use App\Models\GrupPegawai;
use Illuminate\Http\Request;


interface GrupPegawaiRepositoryInterface
{
    public function create(array $data);
    public function get(Request $request);
    public function getById(string $id): ?GrupPegawai;
    public function update(string $id, array $data);
    public function delete(string $id);
}
