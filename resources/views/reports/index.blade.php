<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Task Reports') }}
            </h2>

            <form method="GET" action="{{ route('admin.reports.index') }}" class="my-4 space-y-4">

                {{-- ROW 1 --}}
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

                    {{-- Search --}}
                    <div class="flex flex-col">
                        <label class="text-sm text-gray-600">Search</label>
                        <input type="text"
                               name="search"
                               placeholder="Task title, description, or member"
                               value="{{ request('search') }}"
                               class="border rounded px-2 py-1">
                    </div>

                    {{-- Member --}}
                    <div class="flex flex-col">
                        <label class="text-sm text-gray-600">Member</label>
                        <select name="user_id" class="border rounded px-2 py-1">
                            <option value="">All Members</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Priority --}}
                    <div class="flex flex-col">
                        <label class="text-sm text-gray-600">Priority</label>
                        <select name="priority" class="border rounded px-2 py-1">
                            <option value="">All</option>
                            <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="flex flex-col">
                        <label class="text-sm text-gray-600">Status</label>
                        <select name="status" class="border rounded px-2 py-1">
                            <option value="">All</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    {{-- Deadline --}}
                    <div class="flex flex-col">
                        <label class="text-sm text-gray-600">Deadline</label>
                        <input type="date"
                               name="deadline"
                               value="{{ request('deadline') }}"
                               class="border rounded px-2 py-1">
                    </div>

                </div>

                {{-- ROW 2 --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

                    {{-- Start Date --}}
                    <div class="flex flex-col">
                        <label class="text-sm text-gray-600">Start Date</label>
                        <input type="date"
                               name="start_date"
                               value="{{ request('start_date') }}"
                               class="border rounded px-2 py-1">
                    </div>

                    {{-- End Date --}}
                    <div class="flex flex-col">
                        <label class="text-sm text-gray-600">End Date</label>
                        <input type="date"
                               name="end_date"
                               value="{{ request('end_date') }}"
                               class="border rounded px-2 py-1">
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-2">
                        <button type="submit"
                                class="w-full bg-blue-600 text-white px-4 py-2 rounded">
                            Filter
                        </button>

                        <a href="{{ route('admin.reports.index') }}"
                           class="w-full text-center bg-gray-400 text-white px-4 py-2 rounded">
                            Clear
                        </a>
                    </div>

                    <div>
                        <a href="{{ route('admin.reports.export', request()->query()) }}"
                           class="w-full inline-block text-center bg-green-600 text-white px-4 py-2 rounded">
                            Export CSV
                        </a>
                    </div>


                </div>

            </form>

        </div>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto">
        <table class="w-full bg-white rounded-lg shadow">
            <thead>
            <tr class="bg-gray-100 text-left">
                <th class="border px-2 py-1">Task</th>
                <th class="border px-2 py-1">Assignee</th>
                <th class="border px-2 py-1">Description</th>
                <th class="border px-2 py-1">Priority</th>
                <th class="border px-2 py-1">Status</th>
                <th class="border px-2 py-1">Deadline</th>
                <th class="border px-2 py-1">Creator</th>
            </tr>
            </thead>
            <tbody>
            @forelse($tasks as $task)
                <tr>
                    <td class="border px-2 py-1">{{ $task->title }}</td>
                    <td class="border px-2 py-1">{{ $task->assignee->name ?? 'N/A' }}</td>
                    <td class="border px-2 py-1">{{ $task->description ?? 'N/A' }}</td>
                    <td class="border px-2 py-1">{{ ucfirst($task->priority) }}</td>
                    <td class="border px-2 py-1">{{ ucfirst($task->status) }}</td>
                    <td class="border px-2 py-1">{{ $task->deadline }}</td>
                    <td class="border px-2 py-1">{{ $task->creator->name ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="border px-2 py-1 text-center">No tasks found</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="mt-6">
            {{ $tasks->links() }}
        </div>

    </div>
</x-app-layout>

