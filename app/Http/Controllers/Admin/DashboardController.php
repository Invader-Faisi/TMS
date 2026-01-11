<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index()
    {
        $users = [
            'totalUsers'   => User::count(),
            'admins'       => User::where('role', 'Admin')->count(),
            'managers'     => User::where('role', 'Manager')->count(),
            'members'      => User::where('role', 'Member')->count(),
        ];

        $stats = [
            'totalTasks'     => Task::count(),
            'pending'   => Task::where('status', 'Pending')->count(),
            'inProgress'   => Task::where('status', 'In Progress')->count(),
            'completed' => Task::where('status', 'Completed')->count(),
            'overdue'   => Task::where('status', '!=', 'Completed')
                ->whereDate('deadline', '<', Carbon::today())
                ->count(),
        ];


        return view('admin.dashboard',  compact('users','stats'));
    }
}
