<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AvailabilitySlot;
use App\Models\Electrician;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'electrician_id' => 'required|exists:electricians,id',
            'date' => 'required|date'
        ]);

        $slots = AvailabilitySlot::where('electrician_id', $request->electrician_id)
            ->whereDate('date', $request->date)
            ->where('is_booked', false)
            ->orderBy('start_time')
            ->get()
            ->map(function ($slot) {
                return [
                    'id' => $slot->id,
                    'start_time' => $slot->start_time->format('H:i'),
                    'end_time' => $slot->end_time->format('H:i'),
                    'formatted_time' => $slot->start_time->format('g:i A') . ' - ' . $slot->end_time->format('g:i A'),
                    'date' => $slot->date->format('Y-m-d')
                ];
            });

        return response()->json($slots);
    }

    public function getMonthlyAvailability(Request $request)
    {
        $request->validate([
            'electrician_id' => 'required|exists:electricians,id',
            'month' => 'required|date_format:Y-m'
        ]);

        $startDate = $request->month . '-01';
        $endDate = date('Y-m-t', strtotime($startDate));

        $slots = AvailabilitySlot::where('electrician_id', $request->electrician_id)
            ->whereBetween('date', [$startDate, $endDate])
            ->where('is_booked', false)
            ->get()
            ->groupBy('date')
            ->map(function ($slots) {
                return $slots->count();
            });

        return response()->json($slots);
    }
}