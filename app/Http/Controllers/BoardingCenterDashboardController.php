<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BoardingCenterDashboardController extends Controller
{

    public function pendingBookings()
    {
        $boardingCenterId = Auth::user()->id;
        $pendingAppointments = Appointment::where('boardingcenter_id', $boardingCenterId)
                                            ->where('status', 'pending')
                                            ->with(['petowner', 'pet'])
                                            ->get();

        return view('pet-boardingcenter.pendingbookings', compact('pendingAppointments'));
    }


}
