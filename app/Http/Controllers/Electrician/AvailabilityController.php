<?php

namespace App\Http\Controllers\Electrician;

use App\Http\Controllers\Controller;
use App\Models\AvailabilitySlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AvailabilityController extends Controller
{
    /**
     * Display a listing of availability slots.
     */
    public function index()
    {
        $electrician = auth()->user()->electrician;
        
        $slots = $electrician->availabilitySlots()
            ->where('date', '>=', now()->subDay())
            ->orderBy('date')
            ->orderBy('start_time')
            ->paginate(20);

        $stats = [
            'total' => $electrician->availabilitySlots()->count(),
            'available' => $electrician->availabilitySlots()->available()->where('date', '>=', now())->count(),
            'booked' => $electrician->availabilitySlots()->where('is_booked', true)->count(),
            'upcoming' => $electrician->availabilitySlots()
                ->available()
                ->whereBetween('date', [now(), now()->addDays(7)])
                ->count(),
        ];

        return view('electrician.availability.index', compact('slots', 'stats'));
    }

    /**
     * Show the form for creating new availability slots.
     */
    public function create()
    {
        return view('electrician.availability.create');
    }

    /**
     * Store a newly created availability slot.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $electrician = auth()->user()->electrician;

        // Check for overlapping slots
        $exists = $electrician->availabilitySlots()
            ->whereDate('date', $validated['date'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']]);
            })
            ->exists();

        if ($exists) {
            return back()->with('error', 'This time slot overlaps with an existing slot.')
                ->withInput();
        }

        AvailabilitySlot::create([
            'electrician_id' => $electrician->id,
            'date' => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'is_booked' => false,
        ]);

        return redirect()->route('electrician.availability.index')
            ->with('success', 'Availability slot created successfully.');
    }

    /**
     * Store multiple availability slots at once.
     */
    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'weekdays' => 'required|array',
            'weekdays.*' => 'integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $electrician = auth()->user()->electrician;
        $created = 0;
        $skipped = 0;

        $start = \Carbon\Carbon::parse($validated['start_date']);
        $end = \Carbon\Carbon::parse($validated['end_date']);

        DB::beginTransaction();

        try {
            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                // Check if this weekday is selected
                if (!in_array($date->dayOfWeek, $validated['weekdays'])) {
                    continue;
                }

                // Check if slot already exists
                $exists = $electrician->availabilitySlots()
                    ->whereDate('date', $date)
                    ->where('start_time', $validated['start_time'])
                    ->exists();

                if ($exists) {
                    $skipped++;
                    continue;
                }

                AvailabilitySlot::create([
                    'electrician_id' => $electrician->id,
                    'date' => $date->format('Y-m-d'),
                    'start_time' => $validated['start_time'],
                    'end_time' => $validated['end_time'],
                    'is_booked' => false,
                ]);

                $created++;
            }

            DB::commit();

            return redirect()->route('electrician.availability.index')
                ->with('success', "Created {$created} availability slots. Skipped {$skipped} existing slots.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create bulk slots. Please try again.');
        }
    }

    /**
     * Show calendar view of availability.
     */
    public function calendar()
    {
        $electrician = auth()->user()->electrician;
        
        $slots = $electrician->availabilitySlots()
            ->where('date', '>=', now()->startOfMonth())
            ->where('date', '<=', now()->addMonths(2)->endOfMonth())
            ->get()
            ->groupBy(function ($slot) {
                return $slot->date->format('Y-m-d');
            });

        return view('electrician.availability.calendar', compact('slots'));
    }

    /**
     * Remove the specified availability slot.
     */
    public function destroy(AvailabilitySlot $availabilitySlot)
    {
        $electrician = auth()->user()->electrician;

        if ($availabilitySlot->electrician_id !== $electrician->id) {
            abort(403);
        }

        if ($availabilitySlot->is_booked) {
            return back()->with('error', 'Cannot delete a booked slot.');
        }

        $availabilitySlot->delete();

        return back()->with('success', 'Availability slot deleted successfully.');
    }
}