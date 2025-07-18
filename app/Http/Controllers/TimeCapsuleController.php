<?php

namespace App\Http\Controllers;

use App\Models\TimeCapsule;
use Illuminate\Http\Request;

class TimeCapsuleController extends Controller
{
    public function get(Request $request)
    {
        $searchTitle = $request->input('title') ?? '';
        $capsules = TimeCapsule::whereLike('title', "%$searchTitle%")->paginate(25);

        return response()->json([
            'payload' => $capsules->items(),
            'total' => $capsules->total(),
            'page' => $capsules->currentPage(),
            'last_page' => $capsules->lastPage()
        ], 200);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'title' => 'string|nullable|max:255',
            'color' => 'string|nullable|max:50',
            'reveal_date' => 'required|date|after:now',
            'location' => 'required|string|max:255',
            'is_surprise_mode' => 'boolean',
            'visibility' => 'required|string|in:public,unlisted,private',
            'content_type' => 'required|string|in:text',
            'content_text' => 'required|string',
        ]);

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

    public function update(Request $request, string $id)
    {


        return response()->json([
            'payload' => null,
        ], 501);
    }

    public function delete(Request $request, string $id)
    {
        $is_success = TimeCapsule::destroy($id);

        if ($is_success === 1) {
            return response()->json([
                'payload' => "Deleted capsule of id `$id`",
            ], 200);
        }
        return response()->json([
            'payload' => "Capsule of id `$id` not found",
        ], 404);

    }
}
