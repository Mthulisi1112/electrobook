@props(['selectedYear', 'route'])

<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form method="GET" action="{{ $route }}" class="flex items-center space-x-4">
        <label for="year" class="text-sm font-medium text-gray-700">Select Year:</label>
        <select name="year" 
                id="year" 
                onchange="this.form.submit()"
                class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-[#3b82f6] focus:border-[#3b82f6]">
            @for($y = now()->year; $y >= now()->year - 3; $y--)
                <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>
        
        <div class="flex space-x-2 ml-4">
            <a href="{{ route('admin.dashboard') }}" 
               class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Back to Dashboard
            </a>
        </div>
    </form>
</div>