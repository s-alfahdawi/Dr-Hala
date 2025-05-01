<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(): JsonResponse
    {
        $articles = Article::all()->map(function ($article) {
            return [
                'id' => $article->id,
                'title' => $article->title,
                'content' => $article->content,
                'images' => collect($article->images)->map(function ($image) {
                    return Str::startsWith($image, ['http://', 'https://'])
                        ? $image
                        : asset('storage/' . $image);
                })->toArray(),
                'created_at' => $article->created_at,
                'updated_at' => $article->updated_at,
            ];
        });

        return response()->json($articles);
    }
}