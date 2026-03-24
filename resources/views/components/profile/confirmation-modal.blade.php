@props(['id' => 'confirmationModal'])

<div id="{{ $id }}" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 max-w-md w-full">
        <h3 class="text-lg font-semibold text-[#1e3a5f] mb-4">Confirm Action</h3>
        <p class="text-sm text-gray-600 mb-4" id="modalMessage"></p>
        <div class="flex justify-end space-x-3">
            <button type="button" onclick="hideModal()" 
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Cancel
            </button>
            <button type="button" id="modalConfirmBtn" 
                    class="px-4 py-2 bg-[#3b82f6] text-white rounded-lg hover:bg-[#2563eb]">
                Confirm
            </button>
        </div>
    </div>
</div>

<script>
function showModal(message, onConfirm) {
    const modal = document.getElementById('{{ $id }}');
    document.getElementById('modalMessage').textContent = message;
    
    const confirmBtn = document.getElementById('modalConfirmBtn');
    confirmBtn.onclick = function() {
        onConfirm();
        hideModal();
    };
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function hideModal() {
    const modal = document.getElementById('{{ $id }}');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('{{ $id }}');
    if (event.target === modal) {
        hideModal();
    }
}
</script>