<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $memberId = Auth::id();

        // Tasks assigned to this member
        $tasks = Task::with('creator')
            ->where('assigned_to', $memberId)
            ->latest()
            ->get();

        // Stats
        $stats = [
            'total'       => $tasks->count(),
            'pending'     => $tasks->where('status', 'Pending')->count(),
            'in_progress' => $tasks->where('status', 'In Progress')->count(),
            'completed'   => $tasks->where('status', 'Completed')->count(),
            'overdue'     => $tasks->where('status', '!=', 'Completed')
                ->where('deadline', '<', now())
                ->count(),
        ];

        // Overdue tasks
        $overdueTasks = $tasks->where('status', '!=', 'Completed')
            ->where('deadline', '<', now());

        // Notifications
        $notifications = auth()->user()->unreadNotifications()->latest()->take(10)->get();

        return view('member.dashboard', compact(
            'tasks',
            'stats',
            'overdueTasks',
            'notifications',
        ));
    }
}
