@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Daftar Mobil</div>



                    <div class="card-body">
                        <form action="{{ route('cars.search') }}" method="GET">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="search" placeholder="Cari mobil...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Cari</button>
                                </div>
                            </div>
                        </form>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Merek</th>
                                    <th>Model</th>
                                    <th>Nomor Plat</th>
                                    <th>Tarif Sewa/hari</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cars as $car)
                                    <tr>
                                        <td>{{ $car->brand }}</td>
                                        <td>{{ $car->model }}</td>
                                        <td>{{ $car->license_plate }}</td>
                                        <td>{{ $car->rental_rate }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a href="{{ route('cars.create') }}" class="btn btn-primary">Tambah Mobil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
