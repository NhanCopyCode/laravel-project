<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\GoogleCalendar\Event;

class GoogleCalendarController extends Controller
{
    //
    public function bookingCalendar()
    {
        // Đảm bảo rằng bạn đã cung cấp ID lịch hợp lệ từ file .env
       
        $events = Event::get();

        dd("xin chaf");
        dd($events);
    }
}
