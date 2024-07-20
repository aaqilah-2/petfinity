<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserTypeController extends Controller
{
    public function store(Request $request) {

        $userType = $request->input('user_type');
        $request->session()->put('user_type', $userType);

        if ($userType === 'Pet-Owner') {
            return redirect()->route('pet-owner.register');
        } elseif ($userType === 'Boarding-Center') {
            return redirect()->route('pet-boardingcenter.register');
        } else {
            return redirect()->route('pet-trainingcenter.register');
        }
    }
    
}
