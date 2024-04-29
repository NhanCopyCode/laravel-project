<?php

namespace App\Http\Controllers\clients;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    //
    public function index()
    {
        $vehicle_list = DB::table('vehicles')
        ->join('carrentalstore', 'carrentalstore.CarRentalStore_id', '=', 'vehicles.CarRentalStore_id')
        ->join('models', 'models.model_id', '=', 'vehicles.model_id')
        ->join('vehiclestatus', 'vehiclestatus.vehicle_status_id', '=', 'vehicles.vehicle_status_id')
        ->join('vehicleimages', 'vehicleimages.vehicle_img_id', '=', 'vehicles.vehicle_image_id')
        ->select('carrentalstore.*', 'vehicles.*', 'vehicleimages.*', 'models.*','vehiclestatus.*')
        ->get();
        return view('clients.home', compact('vehicle_list'));

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
