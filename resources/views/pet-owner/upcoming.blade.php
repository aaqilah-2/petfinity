<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Boarding Appointments</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka+One&family=Nunito&display=swap');

        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(to right, #ff6a00, #ffb900);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }

        .animation-bg::before, .animation-bg::after {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            top: -100%;
            left: -100%;
            background: rgba(255, 255, 255, 0.1);
            animation: rotate 30s infinite linear;
            z-index: 0;
        }

        .animation-bg::after {
            background: rgba(255, 255, 255, 0.2);
            animation-duration: 60s;
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .container {
            max-width: 1200px;
            margin: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
        }

        h1 {
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #333;
            font-family: 'Fredoka One', cursive;
        }

        .list-group {
            counter-reset: appointment-counter;
        }

        .card {
            display: flex;
            flex-direction: column;
            align-items: center;
            border: 2px solid #ffa500;
            border-radius: 15px;
            margin-bottom: 20px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #fffae6;
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
        }

        .card::before {
            counter-increment: appointment-counter;
            content: counter(appointment-counter);
            position: absolute;
            top: -15px;
            left: -15px;
            background: #ff6a00;
            color: white;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: bold;
            font-size: 1em;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card div {
            margin: 10px 0;
            text-align: center;
        }

        .service-type {
            background-color: #ffa500;
            color: black;
            padding: 10px 20px;
            border-radius: 20px;
            display: inline-block;
            min-width: 150px;
            text-align: center;
            font-size: 1.1em;
            font-weight: bold;
        }

        .card p {
            margin: 5px 0;
        }

        .heading {
            font-weight: bold;
            color: #555;
        }

        .countdown {
            color: green;
            min-width: 100px;
            text-align: center;
            font-weight: bold;
        }

        .no-appointments {
            text-align: center;
            font-size: 18px;
            color: #777;
            margin-top: 20px;
        }

        @media (min-width: 768px) {
            .card {
                flex-direction: row;
                justify-content: space-between;
                padding: 20px 40px;
            }

            .card div {
                margin: 10px;
                text-align: left;
            }

            .service-type,
            .countdown {
                text-align: center;
                flex-basis: 100%;
                margin: 10px 0;
            }
        }

        @media (min-width: 992px) {
            .card div {
                flex-basis: 24%;
                text-align: left;
                margin: 10px 1%;
            }

            .service-type,
            .countdown {
                flex-basis: auto;
                margin: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="animation-bg"></div>
    <div class="container">
        <h1>Upcoming Boarding Appointments</h1>
        @if ($appointments->isEmpty())
        <p class="no-appointments">No upcoming boarding appointments.</p>
        @else
        <div class="list-group">
            @foreach ($appointments as $appointment)
            <div class="card">
                <div class="service-type">
                    <p class="heading">Service Type</p>
                    <p>Boarding</p>
                </div>
                <div>
                    <p class="heading">Pet Name</p>
                    <p>{{ $appointment->pet_name }}</p>
                </div>
                <div>
                    <p class="heading">Boarding Center</p>
                    <p>{{ $appointment->boarding_center_name }}</p>
                </div>
                <div>
                    <p class="heading">Start Date</p>
                    <p>{{ Carbon\Carbon::parse($appointment->start_date)->format('d-m-Y H:i') }}</p>
                </div>
                <div>
                    <p class="heading">End Date</p>
                    <p>{{ Carbon\Carbon::parse($appointment->end_date)->format('d-m-Y H:i') }}</p>
                </div>
                <div>
                    <p class="heading">Check-in Time</p>
                    <p>{{ Carbon\Carbon::parse($appointment->check_in_time)->format('H:i') }}</p>
                </div>
                <div>
                    <p class="heading">Check-out Time</p>
                    <p>{{ Carbon\Carbon::parse($appointment->check_out_time)->format('H:i') }}</p>
                </div>
                <div>
                    <p class="heading">Payment Method</p>
                    <p>{{ $appointment->payment_method }}</p>
                </div>
                <div class="countdown">
                    <p class="heading">Countdown</p>
                    <span class="countdown-timer" data-date="{{ $appointment->start_date }}"></span>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <script>
        document.querySelectorAll('.countdown-timer').forEach(timer => {
            const startDate = new Date(timer.getAttribute('data-date')).getTime();
            const updateCountdown = () => {
                const now = new Date().getTime();
                const distance = startDate - now;

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

                timer.innerHTML = `${days}d ${hours}h ${minutes}m`;

                if (distance < 0) {
                    timer.innerHTML = "EXPIRED";
                }
            };

            updateCountdown();
            setInterval(updateCountdown, 60000);
        });
    </script>
</body>

</html>
