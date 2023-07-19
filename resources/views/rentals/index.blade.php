@extends('layouts.navbar')

@section('content')
    <div class="container">
        <h1>Available Cars</h1>
        <h4>Silahkan pilih tanggal selain yang telah di booking</h4>
        <table id="carsTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>License Plate</th>
                    <th>Daily Rate</th>
                    <th>Telah dibooking</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cars as $car)
                    <tr>
                        <td>{{ $car->brand }}</td>
                        <td>{{ $car->model }}</td>
                        <td>{{ $car->license_plate }}</td>
                        <td>{{ $car->rental_rate }}</td>
                        <td>
                            @foreach ($car->rentals as $rental)
                                {{ \Carbon\Carbon::parse($rental->start_date)->format('d/m/Y') }} -
                                {{ \Carbon\Carbon::parse($rental->end_date)->format('d/m/Y') }}<br>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('rentals.create', $car->id) }}" class="btn btn-primary">Rent</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#carsTable').DataTable();
        });
    </script>
@endsection
