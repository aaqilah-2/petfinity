<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PetOwnerDashboardController extends Controller
{
    public function index() {
        $pets = auth()->user()->pets;
        return view('pet-owner.mypets', compact('pets'));
    }
}
