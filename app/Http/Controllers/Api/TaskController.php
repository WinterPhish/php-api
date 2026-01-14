<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->tasks;
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);

        return $request->user()->tasks()->create([
            'title' => $request->title
        ]);
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== $request->user()->id) {
            abort(403);
        }

        $task->update($request->only('title', 'completed'));

        return $task;
    }

    public function destroy(Request $request, Task $task)
    {
        if ($task->user_id !== $request->user()->id) {
            abort(403);
        }

        $task->delete();

        return ['success' => true];
    }
}
