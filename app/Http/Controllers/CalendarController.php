<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    //
    public function index()
    {
        // dd('xin chào');
        $rentals = Rental::with(['user', 'vehicle'])
            ->join('vehicles', 'vehicles.vehicle_id', '=' , 'rental.vehicle_id')
            ->join("models", 'models.model_id', '=' , 'vehicles.model_id')
            ->where('user_id', Auth::guard('web')->id())
            ->whereIn('rental.rental_status_id', [1,2,4])  // Chỉ lấy dữ liệu thuê xe của khách hàng hiện tại
            ->get();

        
        $events = $rentals->map(function($rental) {
            return [
                'id' => $rental->rental_id,
                'title' => $rental->model_name,
                'start' => $rental->rental_start_date,
                'end' => $rental->rental_end_date,
            ];
        });

        // dd($events);

        return view('clients.calendar.showCalendar', compact('events'));
    }
}
