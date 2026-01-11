<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Total Users -->
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-sm text-gray-500">Total Users</h3>
                <p class="text-3xl font-bold">{{ $users['totalUsers'] }}</p>
            </div>

            <!-- Managers -->
            <div class="bg-red-300 p-6 rounded-xl shadow">
                <h3 class="text-sm text-gray-500">Managers</h3>
                <p class="text-3xl font-bold">{{ $users['managers'] }}</p>
            </div>

            <!-- Members -->
            <div class="bg-amber-200 p-6 rounded-xl shadow">
                <h3 class="text-sm text-gray-500">Members</h3>
                <p class="text-3xl font-bold">{{ $users['members'] }}</p>
            </div>

        </div>
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-5 gap-6 mb-6">
            <!-- Tasks -->
            <div class="bg-white p-5 rounded-xl shadow">
                <h3 class="text-sm text-gray-500">Total Tasks</h3>
                <p class="text-2xl font-bold">{{ $stats['totalTasks'] }}</p>
            </div>

            <div class="bg-yellow-100 p-5 rounded-xl shadow">
                <h3 class="text-sm text-yellow-800">Pending Tasks</h3>
                <p class="text-2xl font-bold">{{ $stats['pending'] }}</p>
            </div>

            <div class="bg-indigo-200 p-5 rounded-xl shadow">
                <h3 class="text-sm text-indigo-800">In Progress Tasks</h3>
                <p class="text-2xl font-bold">{{ $stats['inProgress'] }}</p>
            </div>

            <div class="bg-green-100 p-5 rounded-xl shadow">
                <h3 class="text-sm text-green-800">Completed Tasks</h3>
                <p class="text-2xl font-bold">{{ $stats['completed'] }}</p>
            </div>

            <div class="bg-red-100 p-5 rounded-xl shadow">
                <h3 class="text-sm text-red-800">Overdue Tasks</h3>
                <p class="text-2xl font-bold">{{ $stats['overdue'] }}</p>
            </div>

        </div>

        <div class="max-w-7xl mx-auto bg-white p-6 rounded-xl shadow mt-8">
            <h3 class="text-lg font-semibold mb-4">Task Status Overview</h3>
            <canvas id="taskChart"></canvas>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('taskChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Pending', 'In Progress', 'Completed', 'Overdue'],
                datasets: [{
                    label: 'Task Status Count',
                    data: [
                        {{ $stats['pending'] ?? 0 }},
                        {{ $stats['inProgress'] ?? 0 }},
                        {{ $stats['completed'] ?? 0 }},
                        {{ $stats['overdue'] ?? 0 }}
                    ],
                    backgroundColor: [
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(255, 99, 132, 0.8)',

                    ],
                    borderColor: [
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                    title: {
                        display: true,
                        text: 'Task Status Distribution',
                        font: {
                            size: 16
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.parsed.y} tasks`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Tasks',
                            font: {
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            stepSize: 1,
                            precision: 0
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Task Status',
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
