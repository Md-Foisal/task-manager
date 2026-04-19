<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Task;
use App\Models\Tag;
use App\Http\Requests\TaskRequest;
use App\Services\TaskService;

class TaskController extends Controller
{
    public function __construct(private TaskService $taskService)
    {
        //
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        $filter = request('filter');

        $tasks = Task::with('tags:id,name')->ForCurrentUser()
        ->when($search, function($query) use ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        })
        ->when($filter === 'completed', function($query) {
            $query->where('is_completed', true);
        })
        ->when($filter === 'incomplete', function($query) {
            $query->where('is_completed', false);
        })
        ->latest()
        ->paginate(5);

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();

        return view('tasks.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $attachmentPath = $this->taskService->handleAttachment($request);

        $this->taskService->createTask($request, $attachmentPath);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        $task->load('tags');

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $this->authorize('view', $task);

        $tags = Tag::all();
        
        $task->load('tags');

        return view('tasks.edit', compact('task', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $attachmentPath = $this->taskService->handleAttachment($request, $task->attachment);

        $this->taskService->updateTask($request, $task, $attachmentPath);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    /**
     * Toggle the completion status of the specified resource.
     */
    public function toggle(Task $task)
    {
        $this->authorize('update', $task);

        $task->update(['is_completed' => !$task->is_completed]);

        if($task->is_completed) {
            return redirect()->route('tasks.index')->with('success', 'Yes! you have completed the task.');
        }

        return redirect()->route('tasks.index')->with('warning', "You didn't complete the task yet. Keep going!");
    }

    /**
     * Display a listing of the trashed resources.
     */
    public function trashed(){
        $tasks = Task::onlyTrashed()->forCurrentUser()->latest()->paginate(5);
        return view('tasks.trashed', compact('tasks'));
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id){
        $task = Task::onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $task);

        $task->restore();
        return redirect()->route('tasks.trashed')->with('success', 'Task restored successfully.');
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete($id){
        $task = Task::onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $task);
        
        if($task->attachment) {
            Storage::disk('public')->delete($task->attachment);
        }
        
        $task->forceDelete();
        return redirect()->route('tasks.trashed')->with('success', 'Task permanently deleted successfully.');
    }
}