<div class="bg-white shadow-lg rounded-lg overflow-hidden">
    @if(isset($header))
        <div class="flex items-center justify-between px-6 py-4 bg-gray-800 text-white">
            {{ $header }}
        </div>
    @endif
    <div class="p-6">
        {{ $slot }}
    </div>
</div>