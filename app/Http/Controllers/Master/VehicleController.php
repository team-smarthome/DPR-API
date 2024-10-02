<?php

namespace App\Http\Controllers\Master;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        return Vehicle::all();
    }

    public function show($id)
    {
        return Vehicle::find($id);
    }

    public function store(Request $request)
    {
        return Vehicle::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $model = Vehicle::find($id);
        $model->update($request->all());
        return $model;
    }

    public function destroy($id)
    {
        return Vehicle::destroy($id);
    }
}
