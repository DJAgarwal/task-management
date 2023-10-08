<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Task,Project};

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $selectedProjectId = $request->project_id;
        $tasks = Task::when($selectedProjectId, function ($query) use ($selectedProjectId) {
            return $query->where('project_id', $selectedProjectId);
        })
        ->orderBy('priority')
        ->orderBy('created_at')
        ->get();

        $projects = Project::all();

        return view('tasks.index', compact('tasks','projects','selectedProjectId'));
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
        ]);

        $task->fill([
            'name' => $request->name,
            'project_id' => $request->project_id,
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
