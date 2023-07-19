<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use App\Models\Returns;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ReturnController extends Controller
{
    public function create()
    {
        return view('returns.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'license_plate' => 'required',
        ]);

        $car = Car::where('license_plate', $request->input('license_plate'))->first();

        if (!$car) {
            return redirect()->back()->with('error', 'Mobil tidak ditemukan.');
        }

        $user = Auth::user();

        $rental = Rental::where('car_id', $car->id)
            ->where('user_id', $user->id)
            ->whereNull('start_date') // Check if start_date is null
            ->whereNull('end_date')   // Check if end_date is null
            ->first();

        if (!$rental) {
            return redirect()->back()->with('error', 'Mobil tidak disewa oleh Anda atau sudah dikembalikan.');
        }

        $rentalDays = Carbon::now()->diffInDays($rental->start_date);
        $rentalFee = $rentalDays * $car->rental_rate;

        Returns::create([
            'user_id' => $user->id, // Retrieve the user ID
            'rental_id' => $rental->id,
            'return_date' => Carbon::now(),
            'rental_days' => $rentalDays,
            'rental_fee' => $rentalFee,
        ]);

        // Set start_date and end_date to null for the current rental
        $rental->start_date = null;
        $rental->end_date = null;
        $rental->save();

        return redirect()->route('returns.create')->with('success', 'Mobil berhasil dikembalikan.');
    }
}
