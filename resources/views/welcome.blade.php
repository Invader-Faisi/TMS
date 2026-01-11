<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>TMS – Task Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-800">

<!-- NAVBAR -->
<nav class="flex items-center justify-center px-8 py-4 border-b">
    <div class="text-4xl font-bold text-indigo-600">
        Task Management System
    </div>
</nav>


<!-- HERO -->
<section class="max-w-7xl mx-auto px-8 py-20 grid md:grid-cols-2 gap-12 items-center">
    <div>
        <h1 class="text-5xl font-extrabold leading-tight mb-6">
            Organize work.<br>
            <span class="text-indigo-600">Achieve more.</span>
        </h1>

        <p class="text-lg text-gray-600 mb-8">
            TMS helps teams create, assign, and track tasks efficiently with
            role-based access, deadlines, notifications, and reports.
        </p>

        <div class="flex space-x-4">
            @guest
                <a href="{{ route('register') }}"
                   class="bg-indigo-600 text-white px-6 py-3 rounded-lg text-lg hover:bg-indigo-700">
                    Register
                </a>

                <a href="{{ route('login') }}"
                   class="border border-gray-300 px-6 py-3 rounded-lg text-lg hover:bg-gray-100">
                    Login
                </a>
            @else
                <a href="{{ route(
                    auth()->user()->isAdmin() ? 'admin.dashboard' :
                    (auth()->user()->isManager() ? 'manager.dashboard' : 'member.dashboard')
                ) }}"
                   class="bg-indigo-600 text-white px-6 py-3 rounded-lg text-lg hover:bg-indigo-700">
                    Go to Dashboard
                </a>
            @endguest
        </div>
    </div>

    <!-- WORKFLOW PREVIEW -->
    <div class="bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-2xl p-8 shadow-lg">
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-lg shadow text-sm">
                <h4 class="font-semibold text-lg">To Do</h4>
                <p class="text-gray-500">Design UI</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow text-sm">
                <h4 class="font-semibold text-lg">In Progress</h4>
                <p class="text-gray-500">Build APIs</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow text-sm">
                <h4 class="font-semibold text-lg">Done</h4>
                <p class="text-gray-500">Auth Setup</p>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section id="features" class="bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-8">
        <h2 class="text-3xl font-bold text-center mb-12">
            Everything your team needs
        </h2>

        <div class="grid md:grid-cols-4 gap-8 text-center">
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="font-semibold text-lg mb-2">Task Management</h3>
                <p class="text-gray-600 text-sm">
                    Create, assign, and manage tasks with priorities.
                </p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="font-semibold text-lg mb-2">RBAC</h3>
                <p class="text-gray-600 text-sm">
                    Admin, Manager, and Member level permissions.
                </p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="font-semibold text-lg mb-2">Notifications</h3>
                <p class="text-gray-600 text-sm">
                    Email & in-app alerts for updates and deadlines.
                </p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="font-semibold text-lg mb-2">Reports</h3>
                <p class="text-gray-600 text-sm">
                    Export task statistics in CSV format.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-20 text-center">
    <h2 class="text-3xl font-bold mb-6">
        Manage tasks smarter with TMS
    </h2>

    @guest
        <a href="{{ route('register') }}"
           class="bg-indigo-600 text-white px-8 py-4 rounded-lg text-lg hover:bg-indigo-700">
            Create Free Account
        </a>
    @else
        <a href="{{ route(
            auth()->user()->isAdmin() ? 'admin.dashboard' :
            (auth()->user()->isManager() ? 'manager.dashboard' : 'member.dashboard')
        ) }}"
           class="bg-indigo-600 text-white px-8 py-4 rounded-lg text-lg hover:bg-indigo-700">
            Open Dashboard
        </a>
    @endguest
</section>

<!-- FOOTER -->
<footer class="bg-gray-50 text-center py-6 text-sm text-gray-500">
    © {{ date('Y') }} Task Management System (TMS)
</footer>

</body>
</html>
