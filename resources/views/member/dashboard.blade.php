<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">
                Member Dashboard
            </h2>

            {{-- Notification Bell --}}
            <div class="relative">
                <a href="#notifications" class="relative inline-flex items-center">
                    🔔
                    @if(auth()->user()->unreadNotifications->count())
                        <span
                            class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span>
                    @endif
                </a>
            </div>
        </div>
    </x-slot>


    <div class="py-12">
        {{-- Notifications --}}
        <div id="notifications" class="max-w-7xl mx-auto mb-6">
            @forelse($notifications as $notification)
                <div class="p-4 mb-3 rounded border bg-blue-50 border-blue-300 flex justify-between">
                    <div>
                        <p class="font-semibold">
                            {{ $notification->data['title'] }}
                        </p>
                        <p class="text-sm">
                            {{ $notification->data['message'] }}
                        </p>
                        <p class="text-xs text-gray-500">
                            Deadline: {{ $notification->data['deadline'] ?? '—' }}
                        </p>
                    </div>

                    <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                        @csrf
                        <button class="text-xs text-blue-700 hover:underline">
                            Mark as Read
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-gray-500">No new notifications</p>
            @endforelse
        </div>


        {{-- Overdue Alert --}}
        @if($overdueTasks->count())
            <div class="max-w-7xl mx-auto mb-6">
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                    <p class="font-semibold text-red-700">
                        You have {{ $overdueTasks->count() }} overdue task(s)
                    </p>
                </div>
            </div>
        @endif

        {{-- Stats --}}
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">

            <div class="bg-white p-5 rounded-xl shadow">
                <h3 class="text-sm text-gray-500">Total</h3>
                <p class="text-2xl font-bold">{{ $stats['total'] }}</p>
            </div>

            <div class="bg-yellow-100 p-5 rounded-xl shadow">
                <h3 class="text-sm text-yellow-800">Pending</h3>
                <p class="text-2xl font-bold">{{ $stats['pending'] }}</p>
            </div>

            <div class="bg-blue-100 p-5 rounded-xl shadow">
                <h3 class="text-sm text-blue-800">In Progress</h3>
                <p class="text-2xl font-bold">{{ $stats['in_progress'] }}</p>
            </div>

            <div class="bg-green-100 p-5 rounded-xl shadow">
                <h3 class="text-sm text-green-800">Completed</h3>
                <p class="text-2xl font-bold">{{ $stats['completed'] }}</p>
            </div>

            <div class="bg-red-100 p-5 rounded-xl shadow">
                <h3 class="text-sm text-red-800">Overdue</h3>
                <p class="text-2xl font-bold">{{ $stats['overdue'] }}</p>
            </div>

        </div>

        {{-- Assigned Tasks --}}
        <div class="max-w-7xl mx-auto bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold mb-4">My Assigned Tasks</h3>

            <table class="w-full text-left border-collapse">
                <thead>
                <tr class="bg-gray-100">
                    <th class="p-3">Title</th>
                    <th class="p-3">Creator</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Deadline</th>
                    <th class="p-3">Action</th>
                </tr>
                </thead>

                <tbody>
                @forelse($tasks as $task)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3">{{ $task->title }}</td>
                        <td class="p-3">{{ $task->creator->name }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded text-xs font-medium
                                @if($task->status === 'Pending') bg-yellow-100 text-yellow-800
                                @elseif($task->status === 'In Progress') bg-blue-100 text-blue-800
                                @elseif($task->status === 'Completed') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $task->status }}
                            </span>
                        </td>
                        <td class="p-3">
                            {{ $task->deadline ?? '—' }}
                        </td>
                        <td class="p-3">
                            <a href="{{ route('tasks.show', $task) }}"
                               class="w-full bg-yellow-600 text-white px-3 py-1 rounded hover:bg-yellow-700">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">
                            No tasks assigned
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
