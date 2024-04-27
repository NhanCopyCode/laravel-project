<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    //
    public function index()
    {
        return view('clients.home');

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
