@extends('layouts.navbar')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Pengembalian Mobil</div>

                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('returns.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="license_plate">Nomor Plat Mobil</label>
                                <input type="text" name="license_plate" id="license_plate" class="form-control" required>
                            </div>

                            <button type="submit" class="btn mt-4 btn-primary">Kembalikan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
