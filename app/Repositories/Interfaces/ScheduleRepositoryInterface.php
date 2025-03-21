<?php

namespace App\Repositories\Interfaces;

use App\Models\Schedule;

interface ScheduleRepositoryInterface
{
    public function all(): \Illuminate\Database\Eloquent\Collection;

    public function create(array $data): ?Schedule;

    public function update(array $data, ?Schedule $schedule);

    public function delete(?Schedule $schedule): bool;

    public function find(?Schedule $schedule): ?Schedule;
}
