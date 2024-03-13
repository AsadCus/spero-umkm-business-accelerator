<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = 'wo';
        // dd($data);
        return view('dashboard', [
            'data' => $data
        ]);
    }
}
