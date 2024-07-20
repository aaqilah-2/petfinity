<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\PetBoardingCenter;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{

    //the form page is this
    public function create($boardingCenterId)
    {
        $boardingCenter = PetBoardingCenter::findOrFail($boardingCenterId);
        $pets = Auth::user()->pets;

        return view('pet-owner.boardingcenter.booking', compact('boardingCenter', 'pets'));
    }

    //this is where the storing happens
    public function store(Request $request)
    {
        $request->validate([
            'boardingcenter_id' => 'required|exists:pet_boarding_centers,id',
            'pet_id' => 'required|exists:pets,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'check_in_time' => 'required|date_format:H:i',
            'check_out_time' => 'required|date_format:H:i',
            'special_notes' => 'nullable|string',
        ]);

        Appointment::create([
            'boardingcenter_id' => $request->boardingcenter_id,
            'petowner_id' => Auth::id(),
            'pet_id' => $request->pet_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'check_in_time' => $request->check_in_time,
            'check_out_time' => $request->check_out_time,
            'special_notes' => $request->special_notes,
            
            'status' => 'pending',
            'payment_status' => 'pending',        
        ]);

        // $notification = Notification::create([
        //     'user_id' => $booking->pet_boarder_id,
        //     'type' => 'booking_request',
        //     'message' => 'You have a new booking request from ' . Auth::user()->name,
        // ]);

        // broadcast(new NotificationEvent($notification))->toOthers();

        // return response()->json(['message' => 'Booking request sent successfully.']);

        return redirect()->route('pet-owner.dashboard')->with('success', 'Appointment created successfully!');
    }


    //showing appointment details for the pet owner 

    public function showAcceptedAppointments()
    {
        $acceptedAppointments = Appointment::where('petowner_id', Auth::id())
                                           ->where('status', 'accepted')
                                           ->where('payment_status', 'pending')
                                           ->with(['boardingcenter', 'pet'])
                                           ->get();

        return view('pet-owner.dashboard', compact('acceptedAppointments'));
    }

    // Method to handle payment selection
    public function selectPaymentMethod(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,card',
        ]);

        $appointment = Appointment::findOrFail($id);

        $appointment->update([
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_method == 'cash' ? 'onvisit' : 'paid', // Assuming immediate update for simplicity
        ]);

        return redirect()->route('pet-owner.dashboard')->with('success', 'Payment method selected successfully.');
    }
}

