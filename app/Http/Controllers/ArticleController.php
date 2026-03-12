<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Repositories\ArticleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    protected ArticleRepository $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of all articles.
     */
    public function index()
    {
        $articles = $this->repository->getAll();
        return response()->json($articles);
    }

    /**
     * Store a newly created article.
     */
    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user || $user->status !== 'activo') {
            return response()->json(['error' => 'Solo usuarios activos pueden realizar esta acción'], 403);
        }

        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'status'       => 'required|in:borrador,publicado',
            'category_ids' => 'required|array',
            'category_ids.*' => 'integer|exists:categories,id',
        ]);

        $data['user_id'] = Auth::id();

        $article = $this->repository->create($data, $request->category_ids);
        return response()->json($article, 201);
    }

    /**
     * Display the specified article.
     */
    public function show(Article $article)
    {
        return response()->json($article->load('categories', 'user'));
    }

    /**
     * Update the specified article.
     */
    public function update(Request $request, Article $article)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user || $user->status !== 'activo') {
            return response()->json(['error' => 'Solo usuarios activos pueden realizar esta acción'], 403);
        }

        if ($article->user_id !== Auth::id()) {
            return response()->json(['error' => 'No tienes permiso para editar este artículo'], 403);
        }

        $data = $request->validate([
            'title'          => 'sometimes|required|string|max:255',
            'content'        => 'sometimes|required|string',
            'status'         => 'sometimes|required|in:borrador,publicado',
            'category_ids'   => 'sometimes|required|array',
            'category_ids.*' => 'integer|exists:categories,id',
        ]);

        $article = $this->repository->update(
            $article->id,
            $data,
            $request->input('category_ids', [])
        );

        return response()->json($article);
    }

    /**
     * Remove the specified article.
     */
    public function destroy(Article $article)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user || $user->status !== 'activo') {
            return response()->json(['error' => 'Solo usuarios activos pueden realizar esta acción'], 403);
        }

        if ($article->user_id !== Auth::id()) {
            return response()->json(['error' => 'No tienes permiso para eliminar este artículo'], 403);
        }

        $this->repository->delete($article->id);
        return response()->json(null, 204);
    }
}
