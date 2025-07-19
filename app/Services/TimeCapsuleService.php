<?php

namespace App\Services;

use App\Models\TimeCapsule;

class TimeCapsuleService
{
    public static function createCapsule($validated_data)
    {
        // Refer to the model's $fillable prop
        return TimeCapsule::create($validated_data);
    }

    public static function searchCapsules($validated_data): array
    {
        $title = $validated_data['title'] ?? '';
        $capsules = TimeCapsule::whereLike('title', "%$title%")->paginate(25);

        return [
            'total' => $capsules->total(),
            'page' => $capsules->currentPage(),
            'last_page' => $capsules->lastPage(),
            'items' => $capsules->items(),
        ];
    }

    public static function updateCapsuleById(string $id, $validated_data)
    {
        $capsule = TimeCapsule::find($id);
        if (!isset($capsule)) {
            return null;
        }

        $capsule->updateOrFail($validated_data);
        return $capsule->getChanges();
    }

    public static function deleteCapsuleById(string $id)
    {
        return TimeCapsule::destroy($id);
    }
}
