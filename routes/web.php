<?php

use App\Models\Pet;
use App\Models\PetBoardingCenter;
use App\Models\PetTrainingCenter;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PetOwnerController;
use App\Http\Controllers\UpcomingController;
use App\Http\Controllers\UserTypeController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BoardingCenterDashboardController;
use App\Http\Controllers\PetBoardingCenterController;
use App\Http\Controllers\PetTrainingCenterController;
use App\Http\Controllers\BoardingCenterDisplayController;
use App\Http\Controllers\BookingHistoryController;
use App\Http\Controllers\PendingBookingsController;

Route::get('/', function () {
    return view('landing-page.welcome');
});


Route::get('Boarding', function () {
    return view('landing-page.boarding');
})->name('Boarding');

Route::get('training', function () {
    return view('landing-page.training');
})->name('training');

Route::get('lostandfound', function () {
    return view('landing-page.lostandfound');
})->name('lostandfound');

Route::get('/features', function () {
    return view('landing-page.features');
});




Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

//choosing the role the user wants to register as :
Route::get('choose-role', function () {
    return view('auth.select-role');
})->name('select-role');

Route::post('choose-role', [UserTypeController::class , 'store'])->name('user-type.store'); 

//register
Route::get('pet-owner/register', [PetOwnerController::class, 'showRegistrationForm'])->name('pet-owner.register');
Route::post('pet-owner/register', [PetOwnerController::class, 'register']);

Route::get('pet-boardingcenter/register', [PetBoardingCenterController::class, 'showRegistrationForm'])->name('pet-boardingcenter.register');
Route::post('pet-boardingcenter/register', [PetBoardingCenterController::class, 'register']);

Route::get('pet-trainingcenter/register', [PetTrainingCenterController::class, 'showRegistrationForm'])->name('pet-trainingcenter.register');
Route::post('pet-trainingcenter/register', [PetTrainingCenterController::class, 'register']);


//login 
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


//middleware
Route::middleware(['auth:petowner'])->group(function () {
    Route::get('petowner/dashboard', [PetOwnerController::class, 'index'])->name('pet-owner.dashboard');
});

Route::middleware(['auth:trainingcenter'])->group(function () {
    Route::get('training/dashboard', [PetTrainingCenterController::class, 'index'])->name('pet-trainingcenter.dashboard');
});

Route::middleware(['auth:boardingcenter'])->group(function () {
    Route::get('petboardingcenter/dashboard', [PetBoardingCenterController::class, 'index'])->name('pet-boardingcenter.dashboard');


    Route::get('/petboardingcenter/pendingrequests', [BoardingCenterDashboardController::class, 'pendingbookings'])->name('pet-boardingcenter.pendingbookings');
    Route::post('/booking/accept/{id}', [PendingBookingsController::class, 'accept'])->name('appointment.accept');



});


//user clicks on navigation bar and is redirected to mypets section
// routes/web.php

Route::middleware('auth:petowner')->group(function () {
    Route::get('mypets', [PetController::class, 'addpetform'])->name('mypets'); // section which says add a pet 
    Route::get('pet-type', [PetController::class, 'pettype'])->name('pettype'); // section which asks the user to select a pet type
    Route::get('/pets/create', [PetController::class, 'create'])->name('pet.create');
    Route::post('/pets', [PetController::class, 'store'])->name('pet.store');

    Route::get('/pets/{id}', [PetController::class, 'show']); // Fetch pet details
Route::get('/pets/{id}/edit', [PetController::class, 'edit'])->name('pets.edit'); // Show edit form
Route::put('/pets/{id}', [PetController::class, 'update'])->name('pets.update'); // Update pet information

});


// Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    // Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    // Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
// });


// pet boarding centers list view and individual view
Route::middleware('auth:petowner')->group(function () {
Route::get('/boarding-centers', [BoardingCenterDisplayController::class, 'index'])->name('boarding-centers.index');
Route::get('/boarding-centers/{id}', [BoardingCenterDisplayController::class, 'show'])->name('boarding-centers.show');
Route::get('/booking/{boardingCenterId}', [AppointmentController::class, 'create'])->name('booking.create');
Route::post('/booking', [AppointmentController::class, 'store'])->name('booking.store');
Route::get('/upcoming', [UpcomingController::class, 'index'])->name('appointments.upcoming');
Route::get('/history', [BookingHistoryController::class, 'index'])->name('appointments.history');


// Route to show accepted appointments for pet owners
Route::get('/pet-owner/accepted-appointments', [AppointmentController::class, 'showAcceptedAppointments'])->name('pet-owner.accepted-appointments');

// Route to handle payment selection
Route::post('/appointment/{id}/select-payment-method', [AppointmentController::class, 'selectPaymentMethod'])->name('appointment.select-payment-method');

Route::get('/petowner/dashboard', [AppointmentController::class, 'showAcceptedAppointments'])->name('pet-owner.dashboard');


});





// Route::middleware(['auth'])->group(function () {
//     Route::get('petowner/dashboard', function () {
//         return view('pet-owner.dashboard');
//     })->name('pet-owner.dashboard');

//     Route::get('pets/add-pet', [PetController::class, 'addpetform'])->name('pets.addpetform');
//     Route::get('pets/pet-type', [PetController::class, 'pettype'])->name('pettype');

//     Route::resource('pets', PetController::class);
// });






// Route::get('choosetype', function () {
//     return view('pet-profile.pet-type');
// })->name('pet-type');

// Route::get('pet-form', function () {
//     return view('pet-profile.pet-form');
// })->name('pet-form');

// Route::post('pet-form', [PetController::class, 'store'])->name('pet.register');

// routes/web.php

// Route::post('/pet-form', [PetController::class, 'store'])->name('pet.store'); // Route to handle form submission

// Route::middleware(['auth:sanctum', 'verified'])->group(function () {
//     Route::get('/pet-owner/dashboard', [PetOwnerController::class, 'index'])->name('pet-owner.dashboard'); // Ensure this route exists for GET requests
//     Route::post('/pet-form', [PetController::class, 'store'])->name('pet.store'); // Route to handle form submission
// });


//pets section
// Route::middleware(['auth'])->group(function () {
//     Route::get('/pets', [PetController::class, 'index'])->name('pets.index');
//     Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create');
//     Route::post('/pets', [PetController::class, 'store'])->name('pets.store');
// });

// Route::get('register-pet', function () {
//     return view('pet-profile.pet-type');
// })->name('pet-type');



// Route::get('/register/user', function () {
//     return view('auth.register-petowner');
// })->name('auth.register-petowner');

// Route::get('/register/boarding-center', function () {
//     return view('auth.register-boardingcenter');
// })->name('auth.register-boardingcenter');

// Route::get('/register/training-center', function () {
//     return view('auth.register-trainingcenter');
// })->name('auth.register-trainingcenter');

// Route::get('/ownerboard', function () {
//     return view('owner-dashboard.home');
// })->name('owner-dashboard.home');