@extends('layouts.navbar')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Peminjaman Mobil</div>

                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('rentals.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="selected_car">Mobil yang Dipilih:</label>
                                <input type="text" id="selected_car" class="form-control"
                                    value="{{ $car->brand }} - {{ $car->model }}" readonly>
                                <input type="hidden" name="car_id" value="{{ $car->id }}">
                            </div>


                            <div class="form-group">
                                <label for="start_date">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="end_date">Tanggal Selesai</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" required>
                            </div>

                            <button type="submit" class="btn mt-4 btn-primary">Pinjam</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
