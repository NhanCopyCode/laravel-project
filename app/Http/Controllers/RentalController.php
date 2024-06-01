<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Payment;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    //
    public function cancelRental(Request $request, $rental)
    {
        // dd($request)
        // dd($rental);
        $rentalId = $rental;
        
        // Tìm Rental theo rental_id
        $rental = Rental::find($rentalId);
        
        if (!$rental) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy đơn thuê xe'
            ], 404);
        }

        // Kiểm tra trạng thái của đơn thuê xe
        if ($rental->rental_status_id == 3) {
            return response()->json([
                'status' => 'error',
                'message' => 'Đơn thuê xe này đã bị hủy'
            ], 400);
        }

        // Cập nhật trạng thái của đơn thuê xe thành "Đã hủy"
        $rental->rental_status_id = 3;
        $rental->is_deleted = true;
        $rental->save();

        // Cập nhật các thanh toán liên quan (nếu có)
        Payment::where('rental_id', $rentalId)
            ->update(['is_deleted' => true]);

        return response()->json([
            'status' => 'success',
            'message' => 'Đã hủy đơn thuê xe thành công'
        ]);
    }
    
}
