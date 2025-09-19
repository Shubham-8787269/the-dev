<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;

class TaskController extends Controller
{
    public function index()
{
    $allTasks = Task::orderBy('position', 'asc')->get();
    $completedTasks = Task::where('completed', true)->orderBy('position', 'asc')->get();
    $incompleteTasks = Task::where('completed', false)->orderBy('position', 'asc')->get();

    return view('dashboard', compact('allTasks', 'completedTasks', 'incompleteTasks'));
}

    public function store(Request $request)
    {
        $data = new Task;
        $data->title = $request->title;
        $data->description = $request->description;
        $data->save();
        return redirect()->back()->with('success', 'Task added successfully!');
    }

   
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->save();

        return redirect()->back()->with('success', 'Task updated successfully');
    }

   
    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();
        return redirect()->back()->with('success', 'Task deleted successfully');
    }
public function reorder(Request $request)
{
    $taskOrder = $request->order;

    foreach ($taskOrder as $index => $taskId) {
        Task::where('id', $taskId)->update(['order' => $index]);
    }

    return response()->json(['status' => 'success']);
}
     public function toggleComplete($id)
    {
        $task = Task::find($id);
        if ($task) {
            $task->completed = !$task->completed; 
            $task->save();
            return redirect()->back()->with('success', 'Task status updated!');
        }
        return redirect()->back()->with('error', 'Task not found!');
    }
}
