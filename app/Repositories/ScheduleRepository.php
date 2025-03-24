<?php

namespace App\Repositories;

use App\Models\Schedule;
use App\Repositories\Interfaces\ScheduleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ScheduleRepository implements ScheduleRepositoryInterface
{
    public function all(): Collection
    {
        return Schedule::all();
    }

    public function create(array $data)
    {
        return Schedule::create($data);
    }

    public function update(array $data, ?Schedule $schedule)
    {

        return $schedule->update($data);
    }

    public function delete(?Schedule $schedule): bool
    {
        return $schedule->delete();
    }

    public function findById(int $id): ?Schedule
    {
        return Schedule::findOrFail($id);
    }
}
