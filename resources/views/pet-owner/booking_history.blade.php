<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History</title>
    <style>
        @keyframes gradientBackground {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap');

        body {
            background: linear-gradient(45deg, #ff6600, #ffeb3b, #ff6600);
            background-size: 200% 200%;
            animation: gradientBackground 15s ease infinite;
            font-family: 'Nunito', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-weight: bold;
            font-size: 36px;
        }

        .card {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            border: 2px solid #ff6600;
            border-radius: 10px;
            margin-bottom: 15px;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card div {
            margin: 10px;
            text-align: center;
            flex: 1;
        }

        .counter {
            position: absolute;
            top: -10px;
            left: -10px;
            background-color: #ff6600;
            color: white;
            font-size: 24px;
            padding: 10px 15px;
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .service-type {
            background-color: #f8ae26;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            min-width: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
        }

        .service-type:hover {
            background-color: #e65c00;
            transform: scale(1.05);
        }

        .service-type i {
            margin-right: 10px;
            color: white;
        }

        .heading {
            font-weight: bold;
            color: #333;
        }

        .status {
            font-weight: bold;
        }

        .status.completed {
            color: green;
        }

        .status.cancelled {
            color: red;
        }

        .icon {
            font-size: 20px;
            margin-bottom: 5px;
            color: #ff6600;
        }

        .no-bookings {
            text-align: center;
            font-size: 18px;
            color: #777;
        }

        @media (max-width: 768px) {
            .card {
                flex-direction: column;
                text-align: center;
            }

            .card div {
                margin: 10px 0;
                text-align: center;
            }

            .service-type {
                margin-bottom: 15px;
                width: 80%;
                padding: 10px;
            }

            .counter {
                position: static;
                margin-bottom: 15px;
                font-size: 20px;
                padding: 5px 10px;
                align: center;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 10px;
            }

            .card {
                padding: 10px;
            }

            .service-type {
                padding: 10px;
                min-width: auto;
                font-size: 14px;
            }

            .card div {
                margin: 5px 0;
            }

            .icon {
                font-size: 18px;
            }

            .counter {
                font-size: 18px;
                padding: 5px 10px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="container">
        <h1>Booking History</h1>
        @if ($appointments->isEmpty())
        <p class="no-bookings">No completed bookings.</p>
        @else
        <div class="list-group">
            @foreach ($appointments as $index => $appointment)
            <div class="card">
                <div class="counter">{{ $index + 1 }}</div>
                
                {{-- <div class="service-type">
                    <i class="fas fa-paw"></i>
                    <p class="heading">Service Type</p>
                    <p>{{ $appointment->service_type }}</p>
                </div> --}}
                <div>
                    <i class="fas fa-dog icon"></i>
                    <p class="heading">Pet Name</p>
                    <p>{{ $appointment->pet_name }}</p>
                </div>
                <div>
                    <i class="fas fa-home icon"></i>
                    <p class="heading">Boarding Center</p>
                    <p>{{ $appointment->boarding_center_name }}</p>
                </div>
                <div>
                    <i class="fas fa-calendar-alt icon"></i>
                    <p class="heading">Start Date</p>
                    <p>{{ Carbon\Carbon::parse($appointment->start_date)->format('d-m-Y H:i') }}</p>
                </div>
                <div>
                    <i class="fas fa-calendar-alt icon"></i>
                    <p class="heading">End Date</p>
                    <p>{{ Carbon\Carbon::parse($appointment->end_date)->format('d-m-Y H:i') }}</p>
                </div>
                <div>
                    <i class="fas fa-clock icon"></i>
                    <p class="heading">Check-in Time</p>
                    <p>{{ Carbon\Carbon::parse($appointment->check_in_time)->format('H:i') }}</p>
                </div>
                <div>
                    <i class="fas fa-clock icon"></i>
                    <p class="heading">Check-out Time</p>
                    <p>{{ Carbon\Carbon::parse($appointment->check_out_time)->format('H:i') }}</p>
                </div>
                <div>
                    <i class="fas fa-credit-card icon"></i>
                    <p class="heading">Payment Method</p>
                    <p>{{ $appointment->payment_method }}</p>
                </div>
                <div class="status {{ $appointment->status }}">
                    <p class="heading">Status</p>
                    <p>{{ ucfirst($appointment->status) }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</body>

</html>
