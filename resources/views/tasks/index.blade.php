<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Tasks</h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto">
        @can('create', App\Models\Task::class)
            <a href="{{ route('tasks.create') }}"
               class="mb-4 inline-block bg-indigo-600 text-white px-4 py-2 rounded">
                Create Task
            </a>
        @endcan

            <table class="w-full table-fixed border-collapse bg-white shadow rounded-lg">
                <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left w-1/6">
                        @if(auth()->user()->isManager())
                            Member
                        @elseif(auth()->user()->isMember())
                            Manager
                        @endif
                    </th>
                    <th class="p-3 text-left w-1/6">Title</th>
                    <th class="p-3 text-left w-1/6">Status</th>
                    <th class="p-3 text-left w-1/6">Priority</th>
                    <th class="p-3 text-left w-1/6">Deadline</th>
                    <th class="p-3 text-left w-1/6">Action</th>
                </tr>
                </thead>

                <tbody>
                @foreach($tasks as $task)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3">
                            @if(auth()->user()->isManager())
                            {{$task->assignee->name}}
                            @elseif(auth()->user()->isMember())
                            {{$task->creator->name}}
                            @endif
                        </td>
                        <td class="p-3 truncate">{{ $task->title }}</td>

                        <td class="p-3">
                    <span class="px-2 py-1 rounded text-sm
                        {{ $task->status == 'Completed' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $task->status == 'In Progress' ? 'bg-yellow-100 text-indigo-700' : '' }}
                        {{ $task->status == 'Pending' ? 'bg-gray-100 text-yellow-700' : '' }}">
                        {{ $task->status }}
                    </span>
                        </td>

                        <td class="p-3">{{ $task->priority }}</td>

                        <td class="p-3">
                            {{ $task->deadline ?? '—' }}
                        </td>

                        <td class="p-3 space-y-2">
                            <a href="{{ route('tasks.show', $task) }}"
                               class="w-full bg-yellow-600 text-white px-3 py-1 rounded hover:bg-yellow-700">
                                View
                            </a>

                            @can('delete', $task)
                                <form method="POST"
                                      action="{{ route('tasks.destroy', $task) }}"
                                      onsubmit="return confirm('Are you sure you want to delete this task?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="w-full bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                        Delete
                                    </button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

    </div>
</x-app-layout>
