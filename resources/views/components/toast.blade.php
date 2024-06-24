@props(['type' => 'success', 'message'])

<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
    class="fixed bottom-4 right-4 p-4 rounded-lg shadow-lg text-white font-bold {{ $type === 'success' ? 'bg-green-500' : 'bg-red-500' }}">
    <p>{{ $message }}</p>
    <button @click="show = false" class="ml-2">
        <i class="fas fa-times"></i>
    </button>
</div>