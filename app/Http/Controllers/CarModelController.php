<?php

namespace App\Http\Controllers;

use App\Models\CarModel;
use Illuminate\Http\Request;

class CarModelController extends Controller
{
    public function index()
    {
        $models = CarModel::with('parts')
            ->get();

        return response()->json($models);
    }

    public function show(CarModel $model)
    {
        $model->load('parts');
        return response()->json($model);
    }

    public function getByBrand($brand)
    {
        $models = CarModel::where('brand', $brand)
            ->with('parts')
            ->get();

        return response()->json($models);
    }
}
