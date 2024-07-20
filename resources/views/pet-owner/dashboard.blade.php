<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <title>Dashboard</title>
</head>

<body class="bg-gray-50">
    <div class="min-h-screen container">

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="p-4">

                <div class="logo-container">
                    {{-- logo --}}
                </div>

                <nav class="space-y-4">
                    <a href="#" class="nav-link">
                        <div class="nav-icon"><x-carbon-home/></div>
                        Home
                    </a>

                    <a href="{{ route('mypets') }}" class="nav-link">
                        <div class="nav-icon"><x-carbon-home/></div>
                        Pets
                    </a>

                    <a href="{{ route('boarding-centers.index') }}" class="nav-link">
                        <div class="nav-icon"><x-carbon-home/></div>
                        Pet Boarding Centers
                    </a>

                    <a href="{{ route('appointments.upcoming') }}" class="nav-link">
                        <div class="nav-icon"><x-carbon-home/></div>
                        Upcoming
                    </a>

                    <a href="{{ route('appointments.history') }}" class="nav-link">
                        <div class="nav-icon"><x-carbon-search/></div>
                        Past Bookings
                    </a>

                    <a href="#" class="nav-link">
                        <div class="nav-icon"><x-carbon-user-avatar/></div>
                        Profile
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="content">
            <div class="header">
                <h1 class="header-title">Welcome To PetFinity,</h1>
                {{-- <h2>Kavina<h2> --}}
                <div class="account-info">
                    <div class="account-icon"></div>
                    {{-- <div class="account-text">Kavina</div> --}}
                </div>
            </div>

            <!-- Accepted Appointments Section -->
            <div class="accepted-appointments-container">
                <h2 class="section-title">Accepted Appointments</h2>
                @if($acceptedAppointments->isEmpty())
                    <p>No accepted bookings.</p>
                @else
                    @foreach($acceptedAppointments as $appointment)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Booking Accepted for {{ $appointment->pet->name }}</h5>
                                <p class="card-text">
                                    <strong>Boarding Center:</strong> {{ $appointment->boardingcenter->name }}<br>
                                    <strong>Start Date:</strong> {{ $appointment->start_date }}<br>
                                    <strong>End Date:</strong> {{ $appointment->end_date }}<br>
                                    <strong>Check-in Time:</strong> {{ $appointment->check_in_time }}<br>
                                    <strong>Check-out Time:</strong> {{ $appointment->check_out_time }}<br>
                                    <strong>Special Notes:</strong> {{ $appointment->special_notes }}
                                    <strong>Special Notes:</strong> {{ $appointment->status }}
                                    <strong>Special Notes:</strong> {{ $appointment->payment_status }}
                                </p>
                                <form action="{{ route('appointment.select-payment-method', $appointment->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="payment_method">Select Payment Method</label>
                                        <select name="payment_method" id="payment_method" class="form-control">
                                            <option value="choosep">choose</option>
                                            <option value="cash">Cash</option>
                                            <option value="card">Card</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Confirm Payment Method</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <!-- End Accepted Appointments Section -->

            <div class="grid">
                <div class="main-content">
                    <div class="reminder-box">
                        <h2 class="section-title">No Bookings</h2>
                        <button class="button-yellow">Book Now!</button>
                    </div>

                    <h2 class="section-title">Around you</h2>
                    <div class="subgrid">
                        <div class="subgrid-item">
                            <div class="subgrid-icon"></div>
                            <h3 class="subgrid-title">Dangers</h3>
                        </div>
                        <div class="subgrid-item">
                            <div class="subgrid-icon"></div>
                            <h3 class="subgrid-title">Poop bags</h3>
                        </div>
                        <div class="subgrid-item">
                            <div class="subgrid-icon"></div>
                            <h3 class="subgrid-title">Dog Parks</h3>
                        </div>
                        <div class="subgrid-item">
                            <div class="subgrid-icon"></div>
                            <h3 class="subgrid-title">Physio</h3>
                        </div>
                        <div class="subgrid-item">
                            <div class="subgrid-icon"></div>
                            <h3 class="subgrid-title">Groomers</h3>
                        </div>
                    </div>

                    <div class="vet-section">
                        <h2 class="section-title">Pet Boarding Center</h2>
                        <div class="vet-box">
                            <div>
                                <h3 class="vet-title">Find a boarding center near you</h3>
                                <button class="button-blue">Place Appointment</button>
                            </div>
                            <div class="vet-icon"><img src="{{ asset('boardingcenter.png') }}" alt="Dog" class="dog-svg"></div>
                        </div>
                    </div>

                    <div class="vet-section">
                        <h2 class="section-title">Pet Training Center</h2>
                        <div class="vet-box">
                            <div>
                                <h3 class="vet-title">Find a training center near you</h3>
                                <button class="button-blue">Book Appointment</button>
                            </div>
                            <div class="vet-icon"><img src="{{ asset('trainer.png') }}" alt="Dog" class="dog-svg"></div>
                        </div>
                    </div>

                    <div class="pets-section">
                        <h2 class="section-title">My pets</h2>
                        <div class="pets-container">
                            <div class="pet-circle">
                                <div class="pet-icon"></div>
                                <h3 class="pet-title">Doggy</h3>
                            </div>
                            <!-- Add more pet circles as needed -->
                            <div class="pet-circle">
                                <div class="pet-icon"></div>
                                <h3 class="pet-title">Kitty</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="reminder-section">
                    <div class="reminder-box">
                        <div class="date-buttons">
                            <button class="date-button">Jun 24</button>
                            <button class="date-button active">Jul 24</button>
                            <button class="date-button">Aug 24</button>
                        </div>
                        <div class="reminder-content">
                            <div class="reminder-icon"></div>
                            <h3 class="reminder-title">No reminders in July</h3>
                            <p class="reminder-text">You can book appointments, add vaccinations or other reminders</p>
                            <button class="button-blue">Book Appointment</button>
                            <button class="button-pink">Add Reminders</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
