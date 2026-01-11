<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Total Users -->
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-sm text-gray-500">Total Users</h3>
                <p class="text-3xl font-bold">{{ $totalUsers }}</p>
            </div>

            <!-- Managers -->
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-sm text-gray-500">Managers</h3>
                <p class="text-3xl font-bold">{{ $managers }}</p>
            </div>

            <!-- Members -->
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-sm text-gray-500">Members</h3>
                <p class="text-3xl font-bold">{{ $members }}</p>
            </div>

            <!-- Tasks -->
            <div class="bg-white p-6 rounded-xl shadow md:col-span-3">
                <h3 class="text-sm text-gray-500">Total Tasks</h3>
                <p class="text-3xl font-bold">{{ $totalTasks ?? 0 }}</p>
            </div>

        </div>
    </div>
</x-app-layout>
