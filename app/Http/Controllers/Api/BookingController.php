<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Repositories\ScheduleRepository;
use App\Services\BookingService;
use Illuminate\Support\Facades\Auth;

class BookingController extends BaseController
{

    public function __construct(protected BookingService $bookingService)
    {
        //
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->bookingService->getAllData();

        return $this->SuccessResponse(
            BookingResource::collection($result),
            'get all data booking',
            200
        );
    }

    public function getDataByPassenger()
    {

        $result = $this->bookingService->getDataByPassenger();

        return $this->SuccessResponse(
            BookingResource::collection($result),
            'get all data booking by passenger ' . Auth::user()->passenger->name,
            200
        );
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
    public function store(StoreBookingRequest $request)
    {
        $result = $this->bookingService->create($request->validated());

        return $this->SuccessResponse(
            new BookingResource($result),
            'Create booking successfully',
            200
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $result = $this->bookingService->show($booking->id);

        return $this->SuccessResponse(
            new BookingResource($result),
            'show detail booking with id ' . $booking->id,
            200
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $this->bookingService->delete($booking);
        return $this->SuccessResponse(
            'delete data booking with id ' . $booking->id,
            200
        );
    }
}
