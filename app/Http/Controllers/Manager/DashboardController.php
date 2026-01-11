<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $managerId = Auth::id();

        $tasks = Task::where('created_by', $managerId)->get();

        $stats = [
            'total'     => $tasks->count(),
            'pending'   => $tasks->where('status', 'Pending')->count(),
            'inProgress'   => $tasks->where('status', 'In Progress')->count(),
            'completed' => $tasks->where('status', 'Completed')->count(),
            'overdue'   => $tasks->where('status', '!=', 'Completed')
                ->where('deadline', '<', now())
                ->count(),
        ];

        // Overdue tasks list
        $overdueTasks = $tasks->where('status', '!=', 'Completed')
            ->where('deadline', '<', now());

        return view('manager.dashboard', compact(
            'tasks',
            'stats',
            'overdueTasks'
        ));
    }
}
