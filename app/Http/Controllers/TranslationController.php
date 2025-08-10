<?php

namespace App\Http\Controllers;

use App\Services\TranslationManagementService;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    protected TranslationManagementService $translationService;

    public function __construct(TranslationManagementService $translationService)
    {
        $this->translationService = $translationService;
    }

    public function index(Request $request)
    {
        return response()->json(
            $this->translationService->getAll($request->only(['tag', 'key', 'content']))
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'key' => 'required|string',
            'locale_id' => 'required|exists:locales,id',
            'content' => 'required|string',
            'tags' => 'nullable|string',
        ]);

        return response()->json(
            $this->translationService->create($data),
            201
        );
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'key' => 'required|string',
            'locale_id' => 'required|exists:locales,id',
            'content' => 'required|string',
            'tags' => 'nullable|string|in:' . implode(',', config('translation.tags')),
        ]);

        $translation = $this->translationService->update($id, $data);

        return $translation
            ? response()->json($translation)
            : response()->json(['error' => 'Not Found'], 404);
    }

    public function export()
    {
        return response()->json($this->translationService->export());
    }
}
