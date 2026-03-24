@props(['data'])

<div class="space-y-8">
    <!-- User Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-500">Total Users</p>
            <p class="text-3xl font-bold text-[#1e3a5f]">{{ $data['total'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-500">New Users</p>
            <p class="text-3xl font-bold text-[#3b82f6]">{{ $data['new'] }}</p>
        </div>
    </div>

    <!-- Users by Role -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-[#1e3a5f] mb-4">Users by Role</h3>
        <div class="space-y-4">
            @foreach($data['by_role'] as $role)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="capitalize">{{ $role->role }}</span>
                        <span class="font-semibold">{{ $role->total }}</span>
                    </div>
                    <x-progress-bar :percentage="($role->total / $data['total']) * 100" 
                                    :color="match($role->role) {
                                        'admin' => 'purple',
                                        'electrician' => 'green',
                                        'client' => 'blue',
                                        default => 'gray'
                                    }" />
                </div>
            @endforeach
        </div>
    </div>
</div>