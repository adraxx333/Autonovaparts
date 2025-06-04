<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;

class PartController extends Controller
{
    public function index()
    {
        $parts = Part::with(['category', 'models'])
            ->select([
                'id',
                'name',
                'code',
                'description',
                'price',
                'stock',
                'image_url',
                'is_active',
                'created_at',
                'updated_at',
                'category_id'
            ])
            ->get();

        return response()->json($parts);
    }

    public function show(Part $part)
    {
        $part->load(['category', 'models']);
        return response()->json($part);
    }
}
