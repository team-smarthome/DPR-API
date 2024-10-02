<?php

namespace App\Repositories\Interfaces;
use Illuminate\Http\Request; 

use App\Models\AbsensiPegawai;

interface AbsensiPegawaiRepositoryInterface
{
    public function create(array $data);
    public function get(Request $request);
    public function getById(string $id);
    public function update(string $id, array $data);
    public function delete(string $id);
}

