<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PendingBookingsController extends Controller
{
    
    public function accept($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => 'accepted']);

        // event(new AppointmentAccepted($appointment));

        return redirect()->route('pet-boardingcenter.dashboard')->with('success', 'Booking request accepted.');
    }

    public function decline(Request $request, $id)
    {
        $request->validate(['reason' => 'required|string|max:255']);

        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => 'declined', 'decline_reason' => $request->reason]);

        // event(new AppointmentDeclined($appointment, $request->reason));

        return redirect()->route('pet-boarder.dashboard')->with('success', 'Booking request declined.');
    }


}
