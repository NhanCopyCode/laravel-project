<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\Rental;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateRentalStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $now = Carbon::now();

        // Cập nhật các đơn đang đợi thuê thành đang thuê nếu ngày bắt đầu <= hiện tại và ngày kết thúc >= hiện tại
        Rental::where('rental_status_id', 1) // Đang đợi thuê
            ->where('rental_start_date', '<=', $now)
            ->where('rental_end_date', '>=', $now)
            ->update(['rental_status_id' => 4]); // Đang thuê

        // Cập nhật các đơn đang thuê thành đã thuê nếu ngày kết thúc < hiện tại
        Rental::where('rental_status_id', 4) // Đang thuê
            ->where('rental_end_date', '<', $now)
            ->update(['rental_status_id' => 2]); // Đã thuê
        
        // dd($now);
        return $next($request);
    }
}
