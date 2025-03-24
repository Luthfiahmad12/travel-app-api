<?php

namespace App\Services;

use App\Models\Schedule;
use App\Repositories\Interfaces\ScheduleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ScheduleService
{
    public function __construct(protected ScheduleRepositoryInterface $scheduleRepository)
    {
        //
    }

    public function all(): Collection
    {
        return $this->scheduleRepository->all();
    }

    public function create(array $data)
    {
        $data['quota'] = 10;
        return $this->scheduleRepository->create($data);
    }

    public function update(array $data, ?Schedule $schedule)
    {
        return $this->scheduleRepository->update($data, $schedule);
    }

    public function delete(?Schedule $schedule)
    {
        $this->scheduleRepository->delete($schedule);
    }

    public function find(?Schedule $schedule)
    {
        return $this->scheduleRepository->findById($schedule->id);
    }
}
