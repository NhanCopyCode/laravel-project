<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\RentalStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminBookingVehicleController extends Controller
{
    //
    public function index()
    {
        // dd('xin chào');
        $list_booking_vehicle = DB::table('payment')
            ->join('rental', 'payment.rental_id', '=', 'rental.rental_id')
            ->join('paymentmethod', 'paymentmethod.payment_method_id', '=', 'payment.payment_method_id')
            ->join('rentalstatus', 'rental.rental_status_id', '=', 'rentalstatus.rental_status_id')
            ->join('vehicles', 'vehicles.vehicle_id', '=', 'rental.vehicle_id' )
            ->join('vehicleimages', 'vehicleimages.vehicle_img_id', '=', 'vehicles.vehicle_image_id')
            ->join('models', 'models.model_id', '=', 'vehicles.model_id')
            ->select(
                '*',
                'payment.is_deleted as payment_is_deleted',
                'rental.is_deleted as rental_is_deleted',
            )
            ->orderBy('payment.payment_id', 'asc')
            ->paginate(5);
            // dd($list_booking_vehicle);
        return view('admin.bookingHistory', compact('list_booking_vehicle'))->with('i', (request()->input('page', 1) - 1) * 5);
        // return view('admin.model', compact('modelList'));
    }
    public function updateBookingVehicleHistory(Request $request)
    {
        // return $request->all();
        $rules = [
            'payment_id' => 'required|exists:payment,payment_id',
            'rental_status_id' => 'required|exists:rentalstatus',
        ];

        $messages = [
            'required' => ':attribute không được để trống',
            'exists' => ':attribute không hợp lệ',
        ];

        $attributes = [
            'payment_id' => 'Thanh toán',
            'rental_status_id' => "Trạng thái thanh toán",
        ];
        $request->validate($rules, $messages, $attributes);

        // $model_id = $request->model_id;
        // $model = model::findOrFail($model_id);

        // dd($request->all());
        $rental = DB::table('rental')
        ->where('rental.rental_id', '=', $request->rental_id)
        ->update([
            'rental_status_id' => $request->rental_status_id,
            
        ]);

        // dd($rental);
        // rental status id === 2 thì "Đã thanh toán"
        $payment = null;
        if($request->rental_status_id == 2) {
            $payment = Payment::where('payment_id', $request->payment_id)->update([
               'payment_date' => now(),
            ]);
        }elseif($request->rental_status_id == 1) {
            $payment = Payment::where('payment_id', $request->payment_id)->update([
                'payment_date' => null
            ]);
        }

       Payment::where('payment_id', $request->payment_id)->update([
            'is_deleted' => $request->is_deleted,
       ]);


        return response()->json([
            'status' => 'success',
            'payment' => $payment,
        ]);
    }

    public function delete(Request $request)
    {
        // dd('Xin chào');
        // $model_id = $request->model_id;

        // if(!$model_id) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Không tìm thấy id của mẫu xe'
        //     ]);
        // }

        // $model = ModelVehicle::find($model_id);
        // if($model) {
        //     $model->delete();
        //     return response()->json([
        //         'status' => 'success',
        //         'message' => 'Xóa thành công mẫu xe'
        //     ]);
        // }else {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Không tìm thấy mẫu xe cần xóa'
        //     ]);
        // }

    }

    public function deleteBoookingVehicleHistory(Request $request)
    {
        dd($request->all());

    }

    public function searchBookingVehicleHistory(Request $request)
    {
        dd($request->all());
    }

}
