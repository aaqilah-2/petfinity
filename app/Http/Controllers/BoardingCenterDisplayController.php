<?php

namespace App\Http\Controllers;

use App\Models\PetBoardingCenter;
use Illuminate\Http\Request;

class BoardingCenterDisplayController extends Controller
{
    public function index()
    {
        $boardingCenters = PetBoardingCenter::all();
        return view('pet-owner.boardingcenter.list', compact('boardingCenters'));
    }

    public function show($id)
    {
        $boardingCenter = PetBoardingCenter::findOrFail($id);
        return view('pet-owner.boardingcenter.detail', compact('boardingCenter'));
    }

    
}
