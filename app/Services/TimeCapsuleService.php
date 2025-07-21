<?php

namespace App\Services;

use App\Models\TimeCapsule;

class TimeCapsuleService
{
    public static function searchCapsules(array $validated): array
    {
        $title = $validated['title'] ?? '';
        $capsules = TimeCapsule::with('user')
            ->whereLike('title', "%$title%")
            ->where('visibility', '=', 'public')
            ->where('reveal_date', '<=', now())
            ->paginate(25);

        $capsules->each(function (TimeCapsule $capsule) {
            $capsule->makeHidden('user_id', 'is_revealed', 'is_surprise_mode', 'visibility');
            $capsule->user->makeHidden('email');
        });

        return [
            'total' => $capsules->total(),
            'page' => $capsules->currentPage(),
            'last_page' => $capsules->lastPage(),
            'items' => $capsules->items(),
        ];
    }

    public static function findCapsuleById(string $id)
    {
        $capsule = TimeCapsule::with('user')->find($id);
        if (!$capsule) {
            return null;
        }

        $capsule->makeHidden('user_id');
        $capsule->user->makeHidden('email');

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
