<?php

namespace App\Http\Controllers;
use App\Tasks;

use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function createTask(Request $request) {
        // Create a new task
        $task = new Tasks();

        $task->tags = $request->input("tags");
        $task->desc = $request->input("desc");
        $task->status = $request->input("status");

        // Save task
        $task->save();

        return response()->json($task);
    }
}
