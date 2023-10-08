<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Task,Project};

class TaskController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        $tasks = Task::orderBy('priority')->orderBy('created_at')->get();
        return view('tasks.index', compact('tasks','projects'));
    }

    public function create()
    {
        $projects = Project::all();
        return view('tasks.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'required',
        ]);

        $task = new Task();
        $task->name = $request->name;
        $task->project_id = $request->project_id;
        $task->priority = $task->getNextPriority();
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Task created successfully');
    }

    public function edit(Task $task)
    {
        $projects = Project::all();
        return view('tasks.edit', compact('task','projects'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'required',
            'priority' => 'required|integer',
        ]);

        $task->fill([
            'name' => $request->name,
            'project_id' => $request->project_id,
            'priority' => $request->priority,
        ]);
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
    }

    public function reorder(Request $request)
    {
        $taskOrder = $request->taskOrder;
        foreach ($taskOrder as $index => $taskId) {
            $task = Task::find($taskId);
            $task->priority = $index + 1;
            $task->save();
        }

        $updatedTasks = Task::orderBy('priority')->get();
        return response()->json($updatedTasks);
    }
}
