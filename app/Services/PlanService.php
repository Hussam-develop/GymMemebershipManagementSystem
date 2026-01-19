<?php

namespace App\Services;

use App\Repositories\PlanRepository;
use App\Models\Plan;

class PlanService
{
    public function __construct(private PlanRepository $repo) {}


    public function getPaginated($pages_count=10)
    {
         return  $this->repo->getPaginated($pages_count);
    }
    public function create(array $data): Plan
    {
        return $this->repo->create($data);
    }

    public function update(Plan $plan, array $data): Plan
    {
        return $this->repo->update($plan, $data);
    }

    public function delete(Plan $plan): void
    {
        $this->repo->delete($plan);
    }

    public function find($plan_id)
    {
      return  $this->repo->find($plan_id);
    }
}
