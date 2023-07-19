<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::all();
        return view('cars.index', compact('cars'));
    }

    public function create()
    {
        return view('cars.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'license_plate' => 'required|unique:cars',
            'rental_rate' => 'required|numeric',
        ]);

        Car::create($request->all());

        return redirect()->route('cars.index')
            ->with('success', 'Car added successfully.');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $cars = Car::where('brand', 'LIKE', "%$search%")
            ->orWhere('model', 'LIKE', "%$search%")
            ->orWhere('license_plate', 'LIKE', "%$search%")
            ->get();

        return view('cars.index', compact('cars'));
    }
}
