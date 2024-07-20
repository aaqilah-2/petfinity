
<div class="container">
    <h2>Pending Booking Requests</h2>

    @foreach($pendingAppointments as $appointment)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Booking Request for {{ $appointment->pet->name }}</h5>
                <p class="card-text">
                    <strong>Pet Owner:</strong> {{ $appointment->petowner->name }}<br>
                    <strong>Start Date:</strong> {{ $appointment->start_date }}<br>
                    <strong>End Date:</strong> {{ $appointment->end_date }}<br>
                    <strong>Check-in Time:</strong> {{ $appointment->check_in_time }}<br>
                    <strong>Check-out Time:</strong> {{ $appointment->check_out_time }}<br>
                    <strong>Special Notes:</strong> {{ $appointment->special_notes }}
                </p>
                <form action="{{ route('appointment.accept', $appointment->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">Accept</button>
                </form>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#declineModal-{{ $appointment->id }}">Decline</button>

                <!-- Decline Modal -->
                <div class="modal fade" id="declineModal-{{ $appointment->id }}" tabindex="-1" aria-labelledby="declineModalLabel-{{ $appointment->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="declineModalLabel-{{ $appointment->id }}">Decline Booking Request</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                {{-- <form action="{{ route('appointment.decline', $appointment->id) }}" method="POST"> --}}
                                    @csrf
                                    <div class="form-group">
                                        <label for="reason">Reason for Declination</label>
                                        <textarea name="reason" id="reason" class="form-control" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-danger">Decline</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Decline Modal -->
            </div>
        </div>
    @endforeach
</div>
