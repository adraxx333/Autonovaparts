<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::select('id', 'name', 'description')
                ->where('is_active', true)
                ->get();

            Log::info('Categorías obtenidas:', ['count' => $categories->count()]);

            return response()->json($categories);
        } catch (\Exception $e) {
            Log::error('Error al obtener categorías: ' . $e->getMessage());
            return response()->json(['error' => 'Error al obtener categorías'], 500);
        }
    }

    public function show(Category $category)
    {
        try {
            $category->load('parts');
            return response()->json($category);
        } catch (\Exception $e) {
            Log::error('Error al obtener categoría: ' . $e->getMessage());
            return response()->json(['error' => 'Error al obtener categoría'], 500);
        }
    }
}
