<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeCapsuleRequest;
use App\Models\TimeCapsule;
use Illuminate\Http\Request;

class TimeCapsuleController extends Controller
{
    // TODO - Guide on code flow and logic:
    // 1. controller gets a request -> pass it to validation
    // 2. pass validated data and request to service class or
    // 3. ??

    public function get(TimeCapsuleRequest $request)
    {
        $validated = $request->validated();

        $title = $validated['title'] ?? '';
        $capsules = TimeCapsule::whereLike('title', "%$title%")->paginate(25);

        return response()->json([
            'payload' => $capsules->items(),
            'total' => $capsules->total(),
            'page' => $capsules->currentPage(),
            'last_page' => $capsules->lastPage()
        ], 200);
    }

    public function create(TimeCapsuleRequest $request)
    {
        $validated = $request->validated();

        $capsule = TimeCapsule::create([
            'title' => $validated['title'] ?? null,
            'color' => $validated['color'] ?? 'gray',
            'reveal_date' => $validated['reveal_date'],
            'location' => $validated['location'],
            'is_surprise_mode' => $validated['is_surprise_mode'] ?? false,
            'visibility' => $validated['visibility'],
            'content_type' => $validated['content_type'],
            'content_text' => $validated['content_text'],
        ]);

        return response()->json([
            'message' => 'Created successfully',
            'payload' => $capsule,
        ], 201);
    }

    public function update(TimeCapsuleRequest $request, string $id)
    {
        $capsule = TimeCapsule::find($id);

        if (!isset($capsule)) {
            return response()->json([
                'message' => "Capsule of id `$id` not found",
            ], 400);
        }

        $validated = $request->validated();

        $is_success = $capsule->update($validated);

        if ($is_success) {
            return response()->json([
                'payload' => $capsule->getChanges(),
            ], 200);
        }

        return response()->json([
            'message' => "Update capsule of id `$id` failed",
        ], 500);
    }

    public function delete(Request $request, string $id)
    {
        $is_success = TimeCapsule::destroy($id);

        if ($is_success === 1) {
            return response()->json([
                'message' => "Deleted capsule of id `$id`",
            ], 200);
        }

        return response()->json([
            'message' => "Capsule of id `$id` not found",
        ], 404);
    }
}
