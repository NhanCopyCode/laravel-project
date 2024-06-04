<?php

namespace App\Http\Controllers\clients;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    //
    public function index(Request $request)
    {
        $page = $request->input('page', 1); // Lấy số trang hiện tại từ request, mặc định là 1
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        // Đếm tổng số vehicles để tính tổng số trang
        $totalVehicles = DB::table('vehicles')->count();
        $totalPages = ceil($totalVehicles / $perPage);

        $vehicles = DB::select(
            "SELECT carrentalstore.*, vehicles.*, vehicleimages.*, models.*, vehiclestatus.*
            FROM vehicles
            JOIN carrentalstore ON carrentalstore.CarRentalStore_id = vehicles.CarRentalStore_id
            JOIN models ON models.model_id = vehicles.model_id
            JOIN vehiclestatus ON vehiclestatus.vehicle_status_id = vehicles.vehicle_status_id
            JOIN vehicleimages ON vehicleimages.vehicle_img_id = vehicles.vehicle_image_id
            LIMIT ? OFFSET ?", 
            [$perPage, $offset]
        );

        return view('clients.home', compact('vehicles', 'page', 'totalPages'));
    }

    public function testmail()
    {
        $name = ' Thành Nhân test email';
        $title = 'Thành Nhân title test email';
        Mail::send('email.test', compact('name'), function ($email) use ($title, $name) {
            $email->subject($title);
            $email->to('20t1020485@husc.edu.vn', $name);
        });
    }
}
