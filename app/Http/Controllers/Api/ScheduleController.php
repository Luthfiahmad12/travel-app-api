<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;
use App\Services\ScheduleService;

class ScheduleController extends Controller
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

        return ScheduleResource::collection($schedules);
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

        $this->scheduleService->create($data);

        return ScheduleResource::collection($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        //
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

        return ScheduleResource::collection($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $this->scheduleService->delete($schedule);
    }
}
