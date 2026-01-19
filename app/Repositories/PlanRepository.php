<?php

namespace App\Repositories;

use App\Models\Plan;

class PlanRepository
{

    public function getPaginated($pages_count = 10)
    {
        return Plan::paginate($pages_count);
    }

    public function create(array $data): Plan
    {
        return Plan::create($data);
    }

    public function update(Plan $plan, array $data): Plan
    {
        $plan->update($data);
        return $plan;
    }

    public function delete(Plan $plan): void
    {
        $plan->delete();
    }

    public function find(int $id): Plan
    {
        return Plan::findOrFail($id);
    }
}
