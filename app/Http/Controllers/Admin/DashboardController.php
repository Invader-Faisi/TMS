<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Console\View\Components\Task;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalUsers'   => User::count(),
            'admins'       => User::where('role', 'Admin')->count(),
            'managers'     => User::where('role', 'Manager')->count(),
            'members'      => User::where('role', 'Member')->count(),
//            'totalTasks'   => Task::count(),
        ]);
    }
}
