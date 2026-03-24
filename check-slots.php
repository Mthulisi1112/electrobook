<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\AvailabilitySlot;

echo "Checking availability slots for electrician 1 on 2026-03-19\n";
echo "====================================================\n\n";

// Check all slots for electrician 1
$allSlots = AvailabilitySlot::where('electrician_id', 1)->get();
echo "Total slots for electrician 1: " . $allSlots->count() . "\n\n";

// Check slots for specific date
$slots = AvailabilitySlot::where('electrician_id', 1)
    ->where('date', '2026-03-19')
    ->where('is_booked', false)
    ->get();

echo "Available slots on 2026-03-19: " . $slots->count() . "\n\n";

if ($slots->count() > 0) {
    echo "Slot details:\n";
    foreach ($slots as $slot) {
        echo "  ID: {$slot->id}\n";
        echo "  Date: {$slot->date}\n";
        echo "  Start: {$slot->start_time}\n";
        echo "  End: {$slot->end_time}\n";
        echo "  Booked: " . ($slot->is_booked ? 'Yes' : 'No') . "\n";
        echo "  ---\n";
    }
} else {
    echo "No slots found. Let's see all slots for electrician 1:\n";
    foreach ($allSlots as $slot) {
        echo "  ID: {$slot->id}, Date: {$slot->date}, Start: {$slot->start_time}, End: {$slot->end_time}, Booked: {$slot->is_booked}\n";
    }
}

echo "\n";