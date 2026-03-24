<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        $services = $query->paginate(15);
        $categories = Service::select('category')->distinct()->pluck('category');

        return view('admin.services.index', compact('services', 'categories'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:services',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'icon' => 'nullable|string',
            'estimated_duration_minutes' => 'required|integer|min:15',
            'is_active' => 'boolean'
        ]);

        Service::create($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:services,name,' . $service->id,
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'icon' => 'nullable|string',
            'estimated_duration_minutes' => 'required|integer|min:15',
            'is_active' => 'boolean'
        ]);

        $service->update($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        // Check if service has any bookings
        if ($service->bookings()->exists()) {
            return back()->with('error', 'Cannot delete service with existing bookings.');
        }

        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }

    public function toggleActive(Service $service)
    {
        $service->update(['is_active' => !$service->is_active]);

        return back()->with('success', 'Service status updated.');
    }
}