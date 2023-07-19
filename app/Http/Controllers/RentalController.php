<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Car;
use App\Models\Rental;
use App\Models\Returns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalController extends Controller
{
    public function index()
    {
        $cars = Car::all();
        return view('rentals.index', compact('cars'));
    }

    public function show()
    {
        $user = Auth::user();

        if ($user->level == 0) {
            // Jika level pengguna adalah 0, tampilkan data sewa mobil berdasarkan id pengguna
            $rentals = Rental::where('user_id', $user->id)->get();
            $returns = Returns::whereIn('rental_id', $rentals->pluck('id'))->get();
        } else {
            // Jika level pengguna bukan 0, tampilkan data sewa mobil untuk semua pengguna
            $rentals = Rental::all();
        }

        return view('rentals.show', compact('rentals', 'returns'));
    }



    public function create($carId)
    {
        $car = Car::findOrFail($carId);

        return view('rentals.create', compact('car'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $car = Car::findOrFail($request->input('car_id'));
        $user = auth()->user();

        // Check if the user has an existing rental for the same car
        $existingRental = Rental::where('user_id', $user->id)
            ->where('car_id', $car->id)
            ->where('end_date', '>=', now())
            ->first();

        if ($existingRental) {
            return redirect()->back()->with('error', 'Anda sudah memiliki peminjaman untuk mobil ini yang masih berlaku.');
        }

        // Check if the car is already rented for the requested dates
        $existingRental = Rental::where('car_id', $car->id)
            ->where(function ($query) use ($request) {
                $query->where('start_date', '<=', $request->input('start_date'))
                    ->where('end_date', '>=', $request->input('start_date'));
            })
            ->orWhere(function ($query) use ($request) {
                $query->where('start_date', '<=', $request->input('end_date'))
                    ->where('end_date', '>=', $request->input('end_date'));
            })
            ->first();

        if ($existingRental) {
            return redirect()->back()->with('error', 'Mobil tidak tersedia pada tanggal yang diminta.');
        }

        Rental::create([
            'user_id' => $user->id,
            'car_id' => $car->id,
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ]);

        return redirect()->route('rentals.show')->with('success', 'Peminjaman berhasil dilakukan.');
    }
}
