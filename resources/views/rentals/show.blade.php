@extends('layouts.navbar')
@section('content')
    <div class="container">
        <h1>Mobil Anda Booking</h1>

        <table id="carsTable" class="table">
            <thead>
                <tr>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>License Plate</th>
                    <th>Daily Rate</th>
                    <th>Rental Cost</th>
                    <th>Remaining Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rentals as $rental)
                    @php
                        $startDate = new DateTime($rental->start_date);
                        $endDate = new DateTime($rental->end_date);
                        $days = $startDate->diff($endDate)->format('%a');
                        $rentalCost = $days * $rental->car->rental_rate;
                    @endphp
                    <tr>
                        <td>{{ $rental->car->brand }}</td>
                        <td>{{ $rental->car->model }}</td>
                        <td>{{ $rental->car->license_plate }}</td>
                        <td>{{ $rental->car->rental_rate }}</td>
                        <td>{{ $rentalCost }}</td>
                        <td data-end-date="{{ $rental->end_date }}"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    </div>

    <script>
        $(document).ready(function() {

            $('#carsTable').DataTable();

            // Calculate remaining time using JavaScript
            $('#carsTable tbody tr').each(function() {
                var endDate = new Date($(this).find('[data-end-date]').data('endDate'));
                var now = new Date();
                var remainingTime = endDate - now;

                if (isNaN(remainingTime) || remainingTime === null) {
                    // Jika remainingTime adalah NaN atau null, tampilkan teks "telah dikembalikan"
                    $(this).find('[data-end-date]').text('telah dikembalikan');
                } else {
                    // Jika remainingTime bukan NaN atau null, hitung dan tampilkan waktu yang tersisa
                    var days = Math.floor(remainingTime / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    $(this).find('[data-end-date]').text(days + ' days ' + hours + ' hours');
                }
            });
        });
    </script>
@endsection
