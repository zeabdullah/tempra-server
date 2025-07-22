<?php

namespace App\Http\Controllers;

use App\Services\TimeCapsuleService;
use App\Http\Requests\TimeCapsule\StoreTimeCapsuleRequest;
use App\Http\Requests\TimeCapsule\SearchTimeCapsuleRequest;
use App\Http\Requests\TimeCapsule\UpdateTimeCapsuleRequest;
use Illuminate\Http\Request;

class TimeCapsuleController extends Controller
{
    public function search(SearchTimeCapsuleRequest $request)
    {
        $validated = $request->validated();
        $paginated_capsules = TimeCapsuleService::searchCapsules($validated);
        return $this->responseJson($paginated_capsules, status: 200);
    }

    public function searchMine(SearchTimeCapsuleRequest $request)
    {
        $validated = $request->validated();
        $paginated_capsules = TimeCapsuleService::searchMyCapsules($validated);
        return $this->responseJson($paginated_capsules, status: 200);

    }

    public function find(Request $request, string $id)
    {
        try {
            $capsule = TimeCapsuleService::findCapsuleById($id);
            if (!$capsule) {
                return $this->notFoundResponse("Model not found");
            }
            return $this->responseJson($capsule, status: 200);
        } catch (\Exception $e) {
            return $this->responseJson(
                message: "Failed to find: " . $e->getMessage(),
                status: 500
            );
        }
    }

    public function store(StoreTimeCapsuleRequest $request)
    {
        $validated = $request->validated();

        try {
            $capsule = TimeCapsuleService::createCapsule($validated, $request);
            return $this->responseJson($capsule, 'Created successfully', 201);
        } catch (\Exception $e) {
            $this->responseJson(message: $e->getMessage(), status: $e->getCode());
        }
    }

    public function update(UpdateTimeCapsuleRequest $request, string $id)
    {
        $validated = $request->validated();

        try {
            $updatedCapsule = TimeCapsuleService::updateCapsuleById($id, $validated);
            if (!isset($updatedCapsule)) {
                return $this->responseJson("Model not found");
            }
            return $this->responseJson($updatedCapsule, 'success', 200);
        } catch (\Exception $e) {
            return $this->responseJson(
                message: "Failed to update: " . $e->getMessage(),
                status: 500
            );
        }
    }

    public function delete(Request $request, string $id)
    {
        try {
            $is_success = TimeCapsuleService::deleteCapsuleById($id);
            if ($is_success === 1) {
                return $this->responseJson(message: "Successfully deleted", status: 200);
            }
            return $this->notFoundResponse("Capsule not found");
        } catch (\Exception $e) {
            return $this->responseJson(
                message: "Failed to delete: " . $e->getMessage(),
                status: 500
            );
        }
    }
}
