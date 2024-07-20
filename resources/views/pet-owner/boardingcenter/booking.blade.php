<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">

        <h1>Book Appointment at {{ $boardingCenter->business_name }}</h1>

        <form action="{{ route('booking.store') }}" method="POST">

            @csrf
            <input type="hidden" name="boardingcenter_id" value="{{ $boardingCenter->id }}">
            <input type="hidden" name="petowner_id" value="{{ Auth::id() }}">

            <div class="mb-3">
                <label for="pet_id" class="form-label">Pet</label>
                <select name="pet_id" id="pet_id" class="form-select" required>
                    @foreach ($pets as $pet)
                        <option value="{{ $pet->id }}">{{ $pet->pet_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="check_in_time" class="form-label">Check-In Time</label>
                <input type="time" name="check_in_time" id="check_in_time" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="check_out_time" class="form-label">Check-Out Time</label>
                <input type="time" name="check_out_time" id="check_out_time" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="special_notes" class="form-label">Special Notes</label>
                <textarea name="special_notes" id="special_notes" class="form-control"></textarea>
            </div>

            {{-- <div class="mb-3">
                <label for="payment_method" class="form-label">Payment Method</label>
                <select name="payment_method" id="payment_method" class="form-select" required>
                    <option value="card">Card</option>
                    <option value="cash">Cash</option>
                </select>
            </div> --}}

            <button type="submit" class="btn btn-primary">Book Appointment</button>
            
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
