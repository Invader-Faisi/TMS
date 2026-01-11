<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Task: {{ $task->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow">

            <form method="POST" action="{{ route('tasks.update', $task) }}">
                @csrf
                @method('PUT')

                <!-- Task Info -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4">Task Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">
                                Title
                            </label>
                            <p class="text-gray-900 font-medium">{{ $task->title }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">
                                Priority
                            </label>
                            <span class="px-2 py-1 text-xs rounded-full font-medium
                                @if($task->priority === 'High') bg-red-100 text-red-800
                                @elseif($task->priority === 'Medium') bg-yellow-100 text-yellow-800
                                @else bg-green-100 text-green-800 @endif">
                                {{ $task->priority }}
                            </span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500 mb-1">
                            Assigned By
                        </label>
                        <p class="text-gray-900">{{ $task->creator->name ?? 'Unknown' }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500 mb-1">
                            Deadline
                        </label>
                        <p class="text-gray-900">
                            @if($task->deadline)
                                {{ \Carbon\Carbon::parse($task->deadline)->format('M d, Y') }}
                                @if(\Carbon\Carbon::parse($task->deadline)->isPast() && $task->status !== 'Completed')
                                    <span class="text-red-600 text-sm ml-2">(Overdue)</span>
                                @endif
                            @else
                                No deadline set
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2 text-gray-700">
                        Description
                    </label>
                    <textarea name="description"
                              rows="4"
                              class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('description', $task->description) }}</textarea>
                    @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="mb-8">
                    <label class="block text-sm font-medium mb-2 text-gray-700">
                        Status
                    </label>
                    <div class="grid grid-cols-3 gap-4">
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="status" value="Pending"
                                   class="h-5 w-5 text-indigo-600"
                                {{ old('status', $task->status) == 'Pending' ? 'checked' : '' }}>
                            <span class="ml-3">
                                <span class="block text-sm font-medium">Pending</span>
                            </span>
                        </label>

                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="status" value="In Progress"
                                   class="h-5 w-5 text-indigo-600"
                                {{ old('status', $task->status) == 'In Progress' ? 'checked' : '' }}>
                            <span class="ml-3">
                                <span class="block text-sm font-medium">In Progress</span>
                            </span>
                        </label>

                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="status" value="Completed"
                                   class="h-5 w-5 text-indigo-600"
                                {{ old('status', $task->status) == 'Completed' ? 'checked' : '' }}>
                            <span class="ml-3">
                                <span class="block text-sm font-medium">Completed</span>
                            </span>
                        </label>
                    </div>
                    @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <input type="hidden" name="title" value="{{ $task->title }}">
                <input type="hidden" name="priority" value="{{ $task->priority }}">
                <input type="hidden" name="deadline" value="{{ $task->deadline }}">
                <input type="hidden" name="assigned_to" value="{{ $task->assigned_to }}">

                <!-- Actions -->
                <div class="flex justify-end space-x-3 pt-6 border-t">
                    <a href="{{ auth()->user()->isMember() ? route('member.dashboard') : route('tasks.index') }}"
                       class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Update Task
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>
