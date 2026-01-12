<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskAssignedNotification;
use App\Notifications\TaskUpdatedNotification;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $tasks = $user->role === 'Manager'
            ? Task::where('created_by', $user->id)->latest()->get()
            : Task::where('assigned_to', $user->id)->latest()->get();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Task::class);

        $members = User::where('role', 'Member')->get();
        return view('tasks.create', compact('members'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Task::class);

        $request->validate([
            'title' => 'required',
            'priority' => 'required',
            'assigned_to' => 'required|exists:users,id',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'deadline' => $request->deadline,
            'assigned_to' => $request->assigned_to,
            'created_by' => Auth::id(),
        ]);

        $member = User::find($task->assigned_to);
        $member->notify(new TaskAssignedNotification($task));

        return redirect()->route('tasks.index')->with('toastr', [
            'type' => 'success',
            'message' => 'Task created successfully',
            'title' => 'Success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);
        return view('tasks.task', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $task->update([
            'status' => $request->status,
            'description' => $request->description
        ]);

        if ($task->assigned_to) {
            $member = User::find($task->assigned_to);

            if ($member) {
                $member->notify(new TaskUpdatedNotification($task));
            }
        }

        return back()->with('toastr', [
            'type' => 'success',
            'message' => 'Task updated successfully',
            'title' => 'Updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()->route('tasks.index')->with('toastr', [
            'type' => 'success',
            'message' => 'Task deleted successfully',
            'title' => 'Deleted'
        ]);
    }
}
