<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $boardingCenter->business_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">

        <h1>{{ $boardingCenter->business_name }}</h1>
        <p><strong>Email:</strong> {{ $boardingCenter->email }}</p>
        <p><strong>City:</strong> {{ $boardingCenter->city }}</p>
        <p><strong>Operating Hours:</strong> {{ $boardingCenter->operating_hours }}</p>
        <p><strong>Social Media Links:</strong> {{ $boardingCenter->socialmedia_links }}</p>
        <p><strong>Special Amenities:</strong> {{ $boardingCenter->special_amenities }}</p>
        <p><strong>Phone:</strong> {{ $boardingCenter->phone_number }}</p>
            <!-- Add other details here -->

        {{-- back button --}}
        <a href="{{ route('boarding-centers.index') }}" class="btn btn-secondary">Back to List</a>

        <a href="{{ route('booking.create' , $boardingCenter->id) }}" class="btn btn-secondary">Book Now</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
