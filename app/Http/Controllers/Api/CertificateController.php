<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\JsonResponse;

class CertificateController extends Controller
{
    public function index(): JsonResponse
    {
        $certificates = Certificate::all()->map(function ($cert) {
            return [
                'id' => $cert->id,
                'title' => $cert->title,
                'specialty' => $cert->specialty,
                'year_obtained' => $cert->year_obtained,
                'image' => $cert->image && str_starts_with($cert->image, 'http')
    ? $cert->image // صورة خارجية جاهزة (picsum)
    : asset('storage/' . $cert->image), // صورة مخزنة محليًا
            ];
        });

        return response()->json([
            'status' => true,
            'data' => $certificates
        ]);
    }
}