<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // GET一覧
    public function index()
    {
        return Task::all();
    }

    // 登録
    public function store(Request $request)
    {
        return Task::create($request->all());
    }

    // 詳細
    public function show(Task $task)
    {
        return $task;
    }

    // 更新
    public function update(Request $request, Task $task)
    {
        $task->update($request->all());

        return $task;
    }
}
