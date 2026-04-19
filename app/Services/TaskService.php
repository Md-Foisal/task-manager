<?php
namespace App\Services;
use Illuminate\Support\Facades\Storage;
use App\Jobs\SendTaskCreateEmail;

class TaskService
{
  public function handleAttachment ($request, $attachment = null) {
    if ($request->hasFile('attachment')) {
      
      if ($attachment) {
        Storage::disk('public')->delete($attachment);
      }
      return $request->file('attachment')->store('attachments', 'public');
    }
    return null;
  }

  public function createTask ($request, $attachmentPath) {
    $task = $request->user()->tasks()->create([
      'title' => $request->title,
      'description' => $request->description,
      'attachment' => $attachmentPath,
      'due_date' => $request->due_date,
    ]);

    $task->tags()->sync($request->tags ?? []);

    SendTaskCreateEmail::dispatch($task);

    return $task;
  }

  public function updateTask ($request, $task, $attachmentPath) {
    $task->update([
      'title' => $request->title,
      'description' => $request->description,
      'attachment' => $attachmentPath ?? $task->attachment,
      'due_date' => $request->due_date,
    ]);

    $task->tags()->sync($request->tags ?? []);

    return $task;
  }
}