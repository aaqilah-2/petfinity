<?php
namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\PetOwner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PetOwnerController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register-petowner');
    }

    public function index()
    {
        return view('pet-owner.dashboard');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $petowner = $this->create($request->all());

        Auth::guard('petowner')->login($petowner);

        return redirect()->route('pet-owner.dashboard');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:pet_owners'],
            'phone_number' => ['required', 'string', 'max:15'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'pets_owned' => 'string',
            'referral_source' => 'string',

        ]);
    }

    protected function create(array $data)
    {
        return PetOwner::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'password' => Hash::make($data['password']),
            'pets_owned' => $data['pets_owned'],
            'referral_source' => $data['referral_source'],
        ]);
    }
}
