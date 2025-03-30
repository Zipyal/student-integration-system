<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::latest()->paginate(10);
        return view('materials.index', compact('materials'));
    }

    public function show(Material $material)
    {
        return view('materials.show', compact('material'));
    }
}