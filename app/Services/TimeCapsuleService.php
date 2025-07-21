<?php

namespace App\Services;

use App\Models\TimeCapsule;

class TimeCapsuleService
{
    public static function searchCapsules(array $validated): array
    {
        $title = $validated['title'] ?? '';
        $capsules = TimeCapsule::whereLike('title', "%$title%")->paginate(25);

        return [
            'total' => $capsules->total(),
            'page' => $capsules->currentPage(),
            'last_page' => $capsules->lastPage(),
            'items' => $capsules->items(),
        ];
    }

    public static function findCapsuleById(string $id)
    {
        $capsule = TimeCapsule::find($id);
        return $capsule;
    }

    public static function createCapsule(array $validated)
    {
        return TimeCapsule::create($validated);
    }

    public static function updateCapsuleById(string $id, array $validated)
    {
        $capsule = TimeCapsule::find($id);
        if (!isset($capsule)) {
            return null;
        }

        $capsule->updateOrFail($validated);
        return $capsule->getChanges(); // TODO: Fix. Not working as planned
    }

    public static function deleteCapsuleById(string $id)
    {
        return TimeCapsule::destroy($id);
    }
}
