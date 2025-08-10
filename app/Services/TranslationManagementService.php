<?php

namespace App\Services;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Collection;

class TranslationManagementService
{
    public function getAll(array $filters = []): Collection
    {
        $query = Translation::query();

        if (!empty($filters['tag'])) {
            $query->where('tags', 'LIKE', "%{$filters['tag']}%");
        }

        if (!empty($filters['key'])) {
            $query->where('key', 'LIKE', "%{$filters['key']}%");
        }

        if (!empty($filters['content'])) {
            $query->where('content', 'LIKE', "%{$filters['content']}%");
        }

        return $query->orderBy('key')->get();
    }

    public function create(array $data): Translation
    {
        return Translation::create($data);
    }

    public function update(int $id, array $data): ?Translation
    {
        $translation = Translation::find($id);
        if ($translation) {
            $translation->update($data);
        }
        return $translation;
    }

    public function export(): Collection
    {
        return Translation::all();
    }
}
