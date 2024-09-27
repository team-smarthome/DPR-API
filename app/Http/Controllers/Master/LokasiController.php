<?php

namespace App\Http\Controllers\Master;

use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index()
    {
        return Lokasi::all();
    }

    public function show($id)
    {
        return Lokasi::find($id);
    }

    public function store(Request $request)
    {
        return Lokasi::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $model = Lokasi::find($id);
        $model->update($request->all());
        return $model;
    }

    public function destroy($id)
    {
        return Lokasi::destroy($id);
    }
}
