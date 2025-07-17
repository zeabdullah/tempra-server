<?php

namespace App\Http\Controllers;

use App\Models\TimeCapsule;
use Illuminate\Http\Request;

class TimeCapsuleController extends Controller
{
    public function getAllTimeCapsules(Request $request)
    {
        $searchTitle = $request->input('title') ?? '';
        $capsules = TimeCapsule::whereLike('title', "%$searchTitle%")->paginate(25);

        return response()->json([
            'payload' => $capsules->items(),
            'total' => $capsules->total(),
            'page' => $capsules->currentPage(),
            'last_page' => $capsules->lastPage()
        ]);
    }
}
