@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add New Car</h1>

        <form action="{{ route('cars.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="brand">Brand</label>
                <input type="text" name="brand" id="brand" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="model">Model</label>
                <input type="text" name="model" id="model" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="license_plate">License Plate</label>
                <input type="text" name="license_plate" id="license_plate" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="rental_rate">rental_rate </label>
                <input type="number" name="rental_rate" id="rental_rate" class="form-control" required>
            </div>

            <button type="submit" class="btn mt-4 btn-primary">Add Car</button>
        </form>
    </div>
@endsection
