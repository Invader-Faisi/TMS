<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Manager Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        @if($overdueTasks->count())
            <div class="max-w-7xl mx-auto mb-6">
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                    <p class="font-semibold text-red-700">
                        You have {{ $overdueTasks->count() }} overdue task(s)
                    </p>
                </div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">

                <div class="bg-white p-5 rounded-xl shadow">
                    <h3 class="text-sm text-gray-500">Total Tasks</h3>
                    <p class="text-2xl font-bold">{{ $stats['total'] }}</p>
                </div>

                <div class="bg-yellow-100 p-5 rounded-xl shadow">
                    <h3 class="text-sm text-yellow-800">Pending</h3>
                    <p class="text-2xl font-bold">{{ $stats['pending'] }}</p>
                </div>

                <div class="bg-indigo-200 p-5 rounded-xl shadow">
                    <h3 class="text-sm text-indigo-800">Pending</h3>
                    <p class="text-2xl font-bold">{{ $stats['inProgress'] }}</p>
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

        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- My Tasks -->
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-gray-500 text-sm">Tasks</h3>
                <p class="text-2xl font-bold mb-4">Manage Tasks</p>

                <a href="{{ route('tasks.index') }}"
                   class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    View Tasks
                </a>
            </div>

            <!-- Create Task -->
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-gray-500 text-sm">Create</h3>
                <p class="text-2xl font-bold mb-4">New Task</p>

                <a href="{{ route('tasks.create') }}"
                   class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Create Task
                </a>
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
