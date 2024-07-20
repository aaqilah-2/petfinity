<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpcomingController extends Controller
{
    public function index()
    {
        // Get the logged-in user
        $user_id = Auth::user()->id;

        // Fetch appointments for the logged-in user with related information using joins
        $appointments = DB::table('appointments')
            ->join('pet_boarding_centers', 'appointments.boardingcenter_id', '=', 'pet_boarding_centers.id')

            ->join('pets', 'appointments.pet_id', '=', 'pets.id')

            ->join('pet_owners', 'appointments.petowner_id', '=', 'pet_owners.id')
            
            // ->where('appointments.start_date', '>=', Carbon::today())
            ->where('appointments.petowner_id', '>=', $user_id)

            ->orderBy('appointments.start_date', 'asc')
            ->select(
                'appointments.*',
                'pet_boarding_centers.business_name as boarding_center_name',
                
                //adding this so when the user clicks on the name a full pet detail should be shown
                'pets.pet_name as pet_name',    
                // 'pet_owners.name as pet_owner_name',
            )
            ->get();

        return view('pet-owner.upcoming', compact('appointments'));
    }
}
