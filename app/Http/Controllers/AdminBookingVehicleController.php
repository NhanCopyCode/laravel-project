<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rental;
use App\Models\Payment;
use App\Models\Vehicle;
use App\Models\RentalStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\admins\ModelVehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\admin\CancleBookingVehicleRequest;

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
            ->orderBy('payment.created_at', 'desc') 
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
        // Xây dựng truy vấn với các joins và select
        $query = DB::table('payment')
            ->join('rental', 'payment.rental_id', '=', 'rental.rental_id')
            ->join('paymentmethod', 'paymentmethod.payment_method_id', '=', 'payment.payment_method_id')
            ->join('rentalstatus', 'rental.rental_status_id', '=', 'rentalstatus.rental_status_id')
            ->join('vehicles', 'vehicles.vehicle_id', '=', 'rental.vehicle_id' )
            ->join('vehicleimages', 'vehicleimages.vehicle_img_id', '=', 'vehicles.vehicle_image_id')
            ->join('models', 'models.model_id', '=', 'vehicles.model_id')
            ->select(
                '*',
                'payment.is_deleted as payment_is_deleted',
                'rental.is_deleted as rental_is_deleted'
            )
            ->where(function($query) use ($request) {
                $query->where('payment_id', 'like', '%'.$request->search_string_payment.'%')
                    ->orWhere('model_name', 'like', '%'.$request->search_string_payment.'%')
                    ->orWhere('amount', 'like', '%'.$request->search_string_payment.'%')
                    ->orWhere('rental_start_date', 'like', '%'.$request->search_string_payment.'%')
                    ->orWhere('rental_end_date', 'like', '%'.$request->search_string_payment.'%')
                    ->orWhere('rental_status_name', 'like', '%'.$request->search_string_payment.'%')
                    ->orWhere('payment_date', 'like', '%'.$request->search_string_payment.'%')
                    ->orWhere('payment_method_name', 'like', '%'.$request->search_string_payment.'%');
            })
            ->orderBy('payment.created_at', 'desc');

            // Phân trang kết quả
            $list_booking_vehicle = $query->paginate(5);

            // Kiểm tra và trả về kết quả
            if ($list_booking_vehicle->count() > 0) {
                return view('blocks.admin.search_admin_booking_vehicle', compact('list_booking_vehicle'))
                    ->with('i', (request()->input('page', 1) - 1) * 5)
                    ->render();
            } else {
                return response()->json([
                    'status' => 'not found',
                    'message' => 'Không tìm thấy giao dịch'
                ]);
            }
        }

        public function  displayCalendar(Request $request)
        {
            $rentals = Rental::with(['user', 'vehicle'])
            ->join('vehicles', 'vehicles.vehicle_id', '=' , 'rental.vehicle_id')
            ->join("models", 'models.model_id', '=' , 'vehicles.model_id')
            ->whereIn('rental.rental_status_id', [1,2,4])  // Chỉ lấy dữ liệu thuê xe của khách hàng hiện tại
            ->get();

        
            $events = $rentals->map(function($rental) {
                return [
                    'rental_id' => $rental->rental_id,
                    'user_id' => $rental->user_id,
                    'vehicle_id' => $rental->vehicle_id,
                    'title' => $rental->model_name,
                    'start' => $rental->rental_start_date,
                    'end' => $rental->rental_end_date,
                ];
            });

            // dd($events);

            return view('admin.booking_calendar', compact('events'));
        }

        public function cancelBookingVehicle(CancleBookingVehicleRequest $request) {

            $reason = $request->reason;

            $rental = Rental::find($request->rental_id);
            $payment = Payment::where('rental_id', $rental->rental_id)->first();

            $vehicle = Vehicle::find($rental->vehicle_id);
            
            $user = User::find($rental->user_id);

            $model = ModelVehicle::find($vehicle->model_id);
            
            // dd($user);
            $rental->rental_status_id = 3; // = 3 có nghĩa là đã Hủy
            $rental->is_deleted = true;
            $rental->save();


            $payment->is_deleted = true;
            $payment->save();

            Mail::send('email.admin_cancel_booking_vehicle', compact('user', 'reason', 'model', 'rental'), function ($email) use($user, $rental) {
                // dd($user); 
                $email->subject('NhanggWebsite - Lịch đăng ký thuê xe của bạn đã bị hủy vui lòng liên hệ sdt 0919094701 để nhận lại tiền đặt xe'); 
                $email->to($user->email, $user->name);

                
            });

           
            return  response()->json(
                [
                    'status' => 'success',
                    'message' => 'Hủy lịch đăng ký xe của người dùng '.$user->name . ' thành công',
                    'rental_canceled' => $rental,
                ]
            );
        }
}
