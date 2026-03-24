@props(['user'])

<section id="profile-info" class="bg-white rounded-xl shadow-lg p-6 scroll-mt-20">
    <h2 class="text-xl font-semibold text-[#1e3a5f] mb-6 flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        Profile Photo
    </h2>
    
    <div class="flex flex-col sm:flex-row items-center sm:items-start space-y-4 sm:space-y-0 sm:space-x-6">
        <div class="shrink-0">
            <div class="relative group">
                <div class="h-28 w-28 rounded-full bg-gradient-to-br from-[#1e3a5f] to-[#3b82f6] flex items-center justify-center text-white text-4xl font-bold overflow-hidden ring-4 ring-white shadow-xl">
                    @if($user->profile_photo_path)
                        <img src="{{ Storage::url($user->profile_photo_path) }}" 
                             alt="{{ $user->name }}" 
                             class="h-full w-full object-cover">
                    @else
                        {{ substr($user->name, 0, 1) }}
                    @endif
                </div>
                <div class="absolute inset-0 bg-black bg-opacity-40 rounded-full opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <span class="text-white text-xs font-medium">Change</span>
                </div>
            </div>
        </div>
        
        <div class="flex-1 text-center sm:text-left">
            <form method="POST" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data" id="photoForm" class="space-y-4">
                @csrf
                <div class="relative">
                    <label for="photo" class="cursor-pointer inline-flex items-center px-5 py-2.5 border-2 border-dashed border-gray-300 rounded-lg hover:border-[#3b82f6] hover:bg-blue-50 transition group">
                        <svg class="w-5 h-5 mr-2 text-gray-400 group-hover:text-[#3b82f6] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm font-medium text-gray-700 group-hover:text-[#3b82f6] transition">Choose New Photo</span>
                    </label>
                    <input type="file" name="photo" id="photo" accept="image/*" class="hidden" onchange="document.getElementById('photoForm').submit();">
                </div>
                
                @if($user->profile_photo_path)
                    <div>
                        <a href="{{ route('profile.photo.delete') }}" 
                           class="text-sm text-red-600 hover:text-red-800 inline-flex items-center"
                           onclick="event.preventDefault(); if(confirm('Are you sure you want to remove your profile photo?')) document.getElementById('delete-photo-form').submit();">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Remove Photo
                        </a>
                    </div>
                @endif
                
                <p class="text-xs text-gray-500">JPG, PNG or GIF. Max 2MB. Square image recommended.</p>
            </form>
            
            @if($user->profile_photo_path)
                <form id="delete-photo-form" method="POST" action="{{ route('profile.photo.delete') }}" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
        </div>
    </div>
    
    @error('photo')
        <p class="mt-4 text-sm text-red-600 bg-red-50 p-3 rounded-lg">{{ $message }}</p>
    @enderror
</section>