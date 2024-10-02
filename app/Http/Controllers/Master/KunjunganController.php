<?php

namespace App\Http\Controllers\Master;

use App\Models\Kunjungan;
use Illuminate\Http\Request;

class KunjunganController extends Controller
{
    public function index()
    {
        return Kunjungan::all();
    }

    public function show($id)
    {
        return Kunjungan::find($id);
    }

    public function store(Request $request)
    {
        return Kunjungan::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $model = Kunjungan::find($id);
        $model->update($request->all());
        return $model;
    }

    public function destroy($id)
    {
        return Kunjungan::destroy($id);
    }
}
