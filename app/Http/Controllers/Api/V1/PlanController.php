<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Plan\StorePlanRequest;
use App\Http\Requests\Plan\UpdatePlanRequest;
use App\Http\Resources\PlanResource;
use App\Models\Plan;
use App\Services\PlanService;
use App\Traits\HandleResponseTrait;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    // Trait to handle response
    use HandleResponseTrait;

    public function __construct(private PlanService $service) {}


    public function index()
    {
        try {
            $plans = $this->service->getPaginated(10); // استدعاء من PlanService
            return $this->sendResponse(
                PlanResource::collection($plans),
                'Plans retrieved successfully',
                200
            );
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve plans', [$e->getMessage()], 500);
        }
    }

    public function store(StorePlanRequest $request)
    {
        try {
            $plan = $this->service->create($request->validated());
            return $this->sendResponse($plan, 'Plan created successfully', 201);
        } catch (\Exception $e) {
            return $this->sendError('Failed to create plan', [$e->getMessage()], 500);
        }
    }

    public function update(UpdatePlanRequest $request, Plan $plan)
    {
        try {
            $plan = $this->service->update($plan, $request->validated());
            return $this->sendResponse($plan, 'Plan updated successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError('Failed to update plan', [$e->getMessage()], 500);
        }
    }

    public function destroy(Plan $plan)
    {
        try {
            $this->service->delete($plan);
            return $this->sendResponse([], 'Plan deleted successfully', 204);
        } catch (\Exception $e) {
            return $this->sendError('Failed to delete plan', [$e->getMessage()], 500);
        }
    }
}
