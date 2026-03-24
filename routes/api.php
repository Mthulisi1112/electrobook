<?php

use App\Models\AvailabilitySlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Get available time slots for a specific electrician and date
Route::get('/available-slots', function (Request $request) {
    $request->validate([
        'electrician_id' => 'required|exists:electricians,id',
        'date' => 'required|date'
    ]);

    try {
        $slots = AvailabilitySlot::where('electrician_id', $request->electrician_id)
            ->whereDate('date', $request->date)
            ->where('is_booked', false)
            ->orderBy('start_time')
            ->get()
            ->map(function ($slot) {
                return [
                    'id' => $slot->id,
                    'start_time' => $slot->start_time->format('g:i A'),
                    'end_time' => $slot->end_time->format('g:i A'),
                    'formatted_time' => $slot->start_time->format('g:i A') . ' - ' . $slot->end_time->format('g:i A')
                ];
            });

        return response()->json($slots);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
})->name('api.available-slots');

// Optional: Get monthly availability overview
Route::get('/monthly-availability', function (Request $request) {
    $request->validate([
        'electrician_id' => 'required|exists:electricians,id',
        'month' => 'required|date_format:Y-m'
    ]);

    try {
        $startDate = $request->month . '-01';
        $endDate = date('Y-m-t', strtotime($startDate));

        $slots = AvailabilitySlot::where('electrician_id', $request->electrician_id)
            ->whereBetween('date', [$startDate, $endDate])
            ->where('is_booked', false)
            ->get()
            ->groupBy(function ($slot) {
                return $slot->date->format('Y-m-d');
            })
            ->map(function ($slots, $date) {
                return [
                    'date' => $date,
                    'count' => $slots->count(),
                    'slots' => $slots->map(function ($slot) {
                        return [
                            'id' => $slot->id,
                            'time' => $slot->start_time->format('g:i A') . ' - ' . $slot->end_time->format('g:i A')
                        ];
                    })
                ];
            })->values();

        return response()->json($slots);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});