<?php

namespace App\Repositories\Interfaces;

use App\Models\WfhPegawai;
use Illuminate\Http\Request;

interface WfhPegawaiRepositoryInterface
{
    public function create(array $data);
    public function get(Request $request);
    public function getById(string $id): ?WfhPegawai;
    public function update(string $id, array $data);
    public function delete(string $id);
}
