<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeCapsuleRequest;
use App\Services\TimeCapsuleService;
use Illuminate\Http\Request;

class TimeCapsuleController extends Controller
{
    public function search(TimeCapsuleRequest $request)
    {
        $validated = $request->validated();
        $paginated_capsules = TimeCapsuleService::searchCapsules($validated);
        return $this->responseJson($paginated_capsules, status: 200);
    }

    public function create(TimeCapsuleRequest $request)
    {
        $validated = $request->validated();
        $capsule = TimeCapsuleService::createCapsule($validated);
        return $this->responseJson($capsule, 'Created successfully', 201);
    }

    public function update(TimeCapsuleRequest $request, string $id)
    {
        $validated = $request->validated();

        try {
            $updatedCapsule = TimeCapsuleService::updateCapsuleById($id, $validated);
            if (!isset($updatedCapsule)) {
                return $this->responseJson(
                    message: "Capsule not found",
                    status: 404
                );
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
                return $this->responseJson(
                    message: "Successfully deleted",
                    status: 200
                );
            }
            return $this->responseJson(
                message: "Capsule not found",
                status: 404
            );
        } catch (\Exception $e) {
            return $this->responseJson(
                message: "Failed to delete: " . $e->getMessage(),
                status: 500
            );
        }
    }
}
