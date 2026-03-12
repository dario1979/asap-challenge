<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of all categories.
     */
    public function index()
    {
        return response()->json(Category::all());
    }

    /**
     * Store a newly created category (admin only).
     */
    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user || $user->role !== 'admin') {
            return response()->json(['error' => 'Solo administradores pueden crear categorías'], 403);
        }

        $data = $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'status'      => 'in:activo,inactivo',
        ]);

        $category = Category::create($data);
        return response()->json($category, 201);
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category)
    {
        return response()->json($category->load('articles'));
    }

    /**
     * Update the specified category (admin only).
     */
    public function update(Request $request, Category $category)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user || $user->role !== 'admin') {
            return response()->json(['error' => 'Solo administradores pueden editar categorías'], 403);
        }

        $data = $request->validate([
            'name'        => 'sometimes|required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'status'      => 'in:activo,inactivo',
        ]);

        $category->update($data);
        return response()->json($category);
    }

    /**
     * Remove the specified category (admin only).
     */
    public function destroy(Category $category)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user || $user->role !== 'admin') {
            return response()->json(['error' => 'Solo administradores pueden eliminar categorías'], 403);
        }

        if ($category->articles()->count() > 0) {
            return response()->json(['error' => 'No se puede eliminar una categoría con artículos'], 422);
        }

        $category->delete();
        return response()->json(null, 204);
    }
}
