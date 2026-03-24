@extends('layouts.app')

@section('title', 'Availability Calendar')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-[#1e3a5f]">Availability Calendar</h1>
            <p class="text-gray-600 mt-2">View your availability across months</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('electrician.availability.index') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                List View
            </a>
            <a href="{{ route('electrician.availability.create') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#3b82f6] hover:bg-[#2563eb]">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Availability
            </a>
        </div>
    </div>

    <!-- Calendar Navigation -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-[#1e3a5f]">
            {{ now()->format('F Y') }} - {{ now()->addMonths(2)->format('F Y') }}
        </h2>
        <p class="text-sm text-gray-600">
            <span class="inline-block w-3 h-3 bg-green-500 rounded-full mr-1"></span> Available
            <span class="inline-block w-3 h-3 bg-amber-500 rounded-full ml-4 mr-1"></span> Booked
        </p>
    </div>

    <!-- Calendar Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @for($monthOffset = 0; $monthOffset < 3; $monthOffset++)
            @php
                $currentMonth = now()->addMonths($monthOffset);
                $startOfMonth = $currentMonth->copy()->startOfMonth();
                $endOfMonth = $currentMonth->copy()->endOfMonth();
                $daysInMonth = $currentMonth->daysInMonth;
                $startDayOfWeek = $startOfMonth->dayOfWeek;
            @endphp

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <!-- Month Header -->
                <div class="bg-[#1e3a5f] text-white px-4 py-3">
                    <h3 class="font-semibold">{{ $currentMonth->format('F Y') }}</h3>
                </div>

                <!-- Weekday Headers -->
                <div class="grid grid-cols-7 gap-px bg-gray-200">
                    @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                        <div class="bg-gray-50 text-center py-2 text-xs font-medium text-gray-500">
                            {{ $day }}
                        </div>
                    @endforeach
                </div>

                <!-- Calendar Days -->
                <div class="grid grid-cols-7 gap-px bg-gray-200">
                    <!-- Empty cells for days before month start -->
                    @for($i = 0; $i < $startDayOfWeek; $i++)
                        <div class="bg-gray-50 min-h-[80px] p-1"></div>
                    @endfor

                    <!-- Days of the month -->
                    @for($day = 1; $day <= $daysInMonth; $day++)
                        @php
                            $currentDate = $currentMonth->copy()->setDay($day);
                            $dateKey = $currentDate->format('Y-m-d');
                            $daySlots = $slots[$dateKey] ?? collect();
                            $availableCount = $daySlots->where('is_booked', false)->count();
                            $bookedCount = $daySlots->where('is_booked', true)->count();
                            $isToday = $currentDate->isToday();
                            $isPast = $currentDate->isPast() && !$isToday;
                        @endphp

                        <div class="bg-white min-h-[80px] p-1 {{ $isToday ? 'ring-2 ring-[#3b82f6]' : '' }} {{ $isPast ? 'opacity-50' : '' }}">
                            <div class="flex justify-between items-start">
                                <span class="text-sm font-medium {{ $isToday ? 'text-[#3b82f6]' : 'text-gray-700' }}">
                                    {{ $day }}
                                </span>
                                @if($daySlots->isNotEmpty())
                                    <span class="text-xs text-gray-500">
                                        {{ $daySlots->count() }} slots
                                    </span>
                                @endif
                            </div>

                            @if($daySlots->isNotEmpty())
                                <div class="mt-1 space-y-1">
                                    @foreach($daySlots->take(2) as $slot)
                                        <div class="text-xs px-1 py-0.5 rounded 
                                            {{ $slot->is_booked ? 'bg-amber-100 text-amber-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $slot->start_time->format('g:i A') }}
                                        </div>
                                    @endforeach
                                    @if($daySlots->count() > 2)
                                        <div class="text-xs text-gray-500 pl-1">
                                            +{{ $daySlots->count() - 2 }} more
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="mt-1 text-xs text-gray-400 italic">
                                    No slots
                                </div>
                            @endif

                            <!-- Mini legend -->
                            @if($availableCount > 0 || $bookedCount > 0)
                                <div class="mt-1 flex items-center space-x-1 text-xs">
                                    @if($availableCount > 0)
                                        <span class="flex items-center">
                                            <span class="w-2 h-2 bg-green-500 rounded-full mr-1"></span>
                                            {{ $availableCount }}
                                        </span>
                                    @endif
                                    @if($bookedCount > 0)
                                        <span class="flex items-center">
                                            <span class="w-2 h-2 bg-amber-500 rounded-full mr-1"></span>
                                            {{ $bookedCount }}
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>
        @endfor
    </div>

    <!-- Legend and Info -->
    <div class="mt-8 bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-[#1e3a5f] mb-4">Understanding Your Calendar</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="flex items-start space-x-3">
                <div class="shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                    </div>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900">Available Slots</h4>
                    <p class="text-sm text-gray-500">Green indicates time slots that are open for booking.</p>
                </div>
            </div>

            <div class="flex items-start space-x-3">
                <div class="shrink-0">
                    <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                        <span class="w-3 h-3 bg-amber-500 rounded-full"></span>
                    </div>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900">Booked Slots</h4>
                    <p class="text-sm text-gray-500">Amber indicates slots that have been booked by clients.</p>
                </div>
            </div>

            <div class="flex items-start space-x-3">
                <div class="shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <span class="text-blue-600 text-sm font-bold">T</span>
                    </div>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900">Today</h4>
                    <p class="text-sm text-gray-500">Days with a blue ring indicate the current date.</p>
                </div>
            </div>
        </div>

        <div class="mt-6 p-4 bg-blue-50 rounded-lg">
            <div class="flex">
                <div class="shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        <strong>Note:</strong> This calendar shows your availability for the next 3 months. 
                        Click on a day with available slots to see detailed timing, or use the 
                        <a href="{{ route('electrician.availability.create') }}" class="font-medium underline">Add Availability</a> 
                        page to create new slots.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection