<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;
use App\Services\ScheduleService;

class ScheduleController extends BaseController
{

    public function __construct(protected ScheduleService $scheduleService)
    {
        //
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = $this->scheduleService->all();

        // return ScheduleResource::collection($schedules);
        return $this->SuccessResponse(ScheduleResource::collection($schedules), 'Lists travel package');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScheduleRequest $request)
    {
        $data = $request->validated();

        $result = $this->scheduleService->create($data);

        return $this->SuccessResponse(new ScheduleResource($result), 'create data successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        $this->scheduleService->find($schedule);

        return $this->SuccessResponse(new ScheduleResource($schedule), 'show data successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        $data = $request->validated();

        $this->scheduleService->update($data, $schedule);

        return $this->SuccessResponse(new ScheduleResource($schedule), 'update data successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $this->scheduleService->delete($schedule);

        return $this->SuccessResponse(new ScheduleResource($schedule), 'delete data successfully');
    }
}
