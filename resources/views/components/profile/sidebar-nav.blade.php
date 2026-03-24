@props(['user'])

<div class="bg-white rounded-xl shadow-lg p-6 sticky top-24">
    <nav class="space-y-2">
        <a href="#profile-info" 
           class="nav-link block px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-[#1e3a5f] transition-all duration-200"
           data-target="profile-info">
            <span class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Profile Information
            </span>
        </a>
        
        <a href="#password" 
           class="nav-link block px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-[#1e3a5f] transition-all duration-200"
           data-target="password">
            <span class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                Change Password
            </span>
        </a>
        
        @if($user->isElectrician())
            <a href="#business-info" 
               class="nav-link block px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-[#1e3a5f] transition-all duration-200"
               data-target="business-info">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Business Information
                </span>
            </a>
        @endif
        
        <a href="#delete-account" 
           class="nav-link block px-4 py-3 rounded-lg text-red-600 hover:bg-red-50 transition-all duration-200"
           data-target="delete-account">
            <span class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Delete Account
            </span>
        </a>
    </nav>

    <div class="mt-6 pt-6 border-t border-gray-200">
        <div class="bg-blue-50 rounded-lg p-4">
            <p class="text-xs text-blue-800">
                <span class="font-semibold">Account Status:</span><br>
                @if($user->hasVerifiedEmail())
                    <span class="text-green-600 flex items-center mt-1">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Email Verified
                    </span>
                @else
                    <span class="text-amber-600 flex items-center mt-1">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        Email Not Verified
                    </span>
                @endif
            </p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Highlight active section on scroll
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-link');
    
    function highlightNavigation() {
        const scrollY = window.pageYOffset;
        
        sections.forEach(section => {
            const sectionHeight = section.offsetHeight;
            const sectionTop = section.offsetTop - 100;
            const sectionId = section.getAttribute('id');
            
            if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                navLinks.forEach(link => {
                    link.classList.remove('bg-blue-50', 'text-[#1e3a5f]', 'font-medium');
                    if (link.getAttribute('data-target') === sectionId) {
                        link.classList.add('bg-blue-50', 'text-[#1e3a5f]', 'font-medium');
                    }
                });
            }
        });
    }
    
    window.addEventListener('scroll', highlightNavigation);
    
    // Smooth scroll
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-target');
            const targetSection = document.getElementById(targetId);
            
            if (targetSection) {
                targetSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>