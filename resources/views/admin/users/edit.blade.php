<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User Role') }}
        </h2>
    </x-slot>

    <div class="pt-5 mt-5 max-w-5xl mx-auto bg-white p-6 rounded-lg shadow">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')

            <label class="block mb-2 font-medium">Role</label>
            <select name="role" class="w-full border rounded p-2">
                <option value="Admin" @selected($user->role == 'admin')>Admin</option>
                <option value="Manager" @selected($user->role == 'manager')>Manager</option>
                <option value="Member" @selected($user->role == 'member')>Member</option>
            </select>

            <button class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded">
                Update Role
            </button>
        </form>
    </div>
</x-app-layout>
