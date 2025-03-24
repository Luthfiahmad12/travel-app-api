<?php

namespace App\Services;

use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Repositories\BookingRepository;
use App\Repositories\ScheduleRepository;
use Illuminate\Support\Facades\Auth;

class BookingService
{
    public function __construct(
        protected ScheduleRepository $scheduleRepository,
        protected BookingRepository $bookingRepository
    ) {
        //
    }

    public function getAllData()
    {
        $data =  $this->bookingRepository->getData();

        return $data->load('passenger', 'transaction');
    }

    public function getDataByPassenger()
    {
        $passenger_id = Auth::user()->passenger->id;
        if (!$passenger_id) {
            throwErrorResponse('Passenger not found', null, 401);
        }

        $data =  $this->bookingRepository->getDataByPassenger($passenger_id);

        return $data->load('transaction');
    }

    public function create(array $data)
    {
        $schedule = $this->scheduleRepository->findById($data['schedule_id']);

        if ($schedule->quota === 0) {
            throwErrorResponse('Kuota travel ini sudah habis.', null, 422);
        } elseif ($schedule->quota <= $data['qty']) {
            throwErrorResponse('Jumlah tiket yang dipesan melebihi kuota yang tersedia.', null, 422);
        } else {
            $schedule->update(['quota' => $schedule->quota - $data['qty']]);

            $data['total_price'] = $schedule->price * $data['qty'];

            $booking = $this->bookingRepository->create($data);

            return $booking->load('schedule', 'passenger', 'transaction');
        }
    }

    public function show(int $id)
    {
        $data =  $this->bookingRepository->findById($id);

        return $data->load('transaction');
    }

    public function delete(?Booking $booking)
    {
        if ($booking->passenger->id !== Auth::user()->passenger->id) {
            throwErrorResponse('Unauthorized', null, 401);
        }
        if (!is_null($booking->transaction())) {
            $booking->transaction()->delete();
        }

        return  $this->bookingRepository->delete($booking);
    }
}
