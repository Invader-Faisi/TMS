<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Create New Task
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">

            <form method="POST" action="{{ route('tasks.store') }}">
                @csrf

                <!-- Task Title -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">
                        Task Title
                    </label>
                    <input type="text"
                           name="title"
                           value="{{ old('title') }}"
                           class="w-full border rounded px-3 py-2"
                           required>
                    @error('title')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">
                        Description
                    </label>
                    <textarea name="description"
                              rows="4"
                              class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
                </div>

                <!-- Priority -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">
                        Priority
                    </label>
                    <select name="priority"
                            class="w-full border rounded px-3 py-2"
                            required>
                        <option value="">Select Priority</option>
                        <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                        <option value="Medium" {{ old('priority') == 'Medium' ? 'selected' : '' }}>Medium</option>
                        <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>High</option>
                    </select>
                    @error('priority')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deadline -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">
                        Deadline
                    </label>
                    <input type="date"
                           name="deadline"
                           value="{{ old('deadline') }}"
                           class="w-full border rounded px-3 py-2">
                </div>

                <!-- Assign To -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-1">
                        Assign To (Member)
                    </label>
                    <select name="assigned_to"
                            class="w-full border rounded px-3 py-2"
                            required>
                        <option value="">Select Member</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}"
                                {{ old('assigned_to') == $member->id ? 'selected' : '' }}>
                                {{ $member->name }} ({{ $member->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('assigned_to')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('tasks.index') }}"
                       class="px-4 py-2 border rounded hover:bg-gray-100">
                        Cancel
                    </a>

                    <button type="submit"
                            class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        Create Task
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>
