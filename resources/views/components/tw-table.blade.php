<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4">
        <div class="overflow-x-auto -mx-4 px-4">
            <table class="min-w-full divide-y divide-gray-200 table-auto">
                <thead class="bg-gray-50">
                    {{ $head ?? '' }}
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    {{ $slot }}
                </tbody>
            </table>
        </div>
    </div>
</div>