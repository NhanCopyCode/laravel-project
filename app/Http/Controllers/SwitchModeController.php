<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SwitchModeController extends Controller
{
    //
    public function switch_mode()
    {
        $mode = session('mode', 'light') === 'light' ? 'dark' : 'light';
        session(['mode' => $mode]);
        return back();
    }
}
