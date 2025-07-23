<?php

namespace App\Services;

use App\Models\TimeCapsule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Location\Facades\Location;
use Illuminate\Database\Eloquent\Builder;

class TimeCapsuleService
{

    public static function searchMyCapsules(array $validated): array
    {
        $user_id = Auth::user()->getAttribute('id');
        $title = $validated['title'] ?? '';

        $capsules = TimeCapsule::
            whereUserId($user_id)
            ->whereLike('title', "%$title%")
            ->where(
                function (Builder $query) {
                    $query
                        ->where('is_surprise_mode', false)
                        ->orWhere(function (Builder $q) {
                            $q
                                ->where('is_surprise_mode', true)
                                ->where('reveal_date', '<=', now());
                        });
                }
            )
            ->paginate(25);

        return [
            'total' => $capsules->total(),
            'page' => $capsules->currentPage(),
            'last_page' => $capsules->lastPage(),
            'items' => $capsules->items(),
        ];
    }

    public static function searchCapsules(array $validated): array
    {
        $title = $validated['title'] ?? '';
        $capsules = TimeCapsule::
            with('user')
            ->whereLike('title', "%$title%")
            ->where('visibility', '=', 'public')
            ->where('reveal_date', '<=', now())
            ->paginate(25);

        $capsules->each(function (TimeCapsule $capsule) {
            $capsule->makeHidden(
                'user_id', // we already have a user object, so we don't need this
                'is_revealed',
                'is_surprise_mode',
                'visibility'
            );
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
        $capsule = new TimeCapsule($validated);
        $position = Location::get();

        if (!$position) {
            dd('failed');
        }

        if (
            $validated['content_type'] === 'image'
            && $img_base64 = $validated['content_image']
        ) {
            $img_url = StorageService::storeBase64Image($img_base64);

            $capsule->makeHidden(['content_text', 'content_voice_url']);
            $capsule['content_image_url'] = $img_url;
        }
        $capsule->mergeFillable(['user_id']);
        $capsule['title'] = $validated['title'] ?? '';
        $capsule['reveal_date'] = Carbon::parse($validated['reveal_date'])->format('Y-m-d h:i:s');
        $capsule['is_surprise_mode'] = $validated['is_surprise_mode'] ?? false;
        $capsule['color'] = $validated['color'] ?? 'blue';
        $capsule['location'] = "$position->cityName, $position->countryName";
        $capsule['user_id'] = Auth::user()->getAttribute('id');

        $capsule->save();
        $capsule->refresh();
        return $capsule;
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
