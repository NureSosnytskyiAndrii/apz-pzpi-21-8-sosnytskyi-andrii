<?php

namespace App\Http\Controllers;

use App\Models\CurrentLocation;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CurrentLocationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'notes' => 'nullable|string',
            'timestamp' => 'nullable|date',
        ]);

        $user = Auth::user();

        $currentLocation = CurrentLocation::create([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'notes' => $request->notes,
            'timestamp' => $request->timestamp,
        ]);

        $employee = Employee::where('user_id', $user->id)->first();

        $employee->location()->attach($currentLocation->id);

        return response()->json(['message' => 'Current location created successfully', 'data' => $currentLocation], 201);
    }
}
