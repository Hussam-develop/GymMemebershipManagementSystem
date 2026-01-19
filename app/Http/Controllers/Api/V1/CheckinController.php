<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checkin\StoreCheckinRequest;
use App\Http\Resources\CheckinResource;
use App\Services\CheckinService;
use App\Traits\HandleResponseTrait;
use Illuminate\Http\Request;

class CheckinController extends Controller
{
    // Trait to handle response

    use HandleResponseTrait;
    public function __construct(private CheckinService $service) {}
    public function store(StoreCheckinRequest $request)
    {
        try {
            $member = $request->get('member'); // Injected by middleware
            $checkin = $this->service->checkin($member);
            return $this->sendResponse(new CheckinResource($checkin), 'Check-in recorded successfully', 201);
        } catch (\Exception $e) {
            return $this->sendError('Failed to record check-in', [$e->getMessage()], 500);
        }
    }
}
