<?php

namespace App\Http\Controllers\api;

use App\Http\Resources\TaskResource;
use App\Task;
use App\Todo;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return TaskResource
     */
    public function index(Request $request)
    {
        //



        $tasks = auth()->user()->tasks()->with('todo');


        //todo remember to use EloquentBuilder
        //todo validate status and title filters
        if (request()->has('filter_by_status')) {
            $tasks->where('status', request('filter_by_status'));

        }
        if (request()->has('filter_by_title')) {
            $tasks->where('title', request('filter_by_title'));
        }

        return new TaskResource($tasks->get());

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  App\Todo $todo
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Todo $todo)
    {
        $task = request()->validate(
            [
                'title' => 'required|string',
                'description' => 'required|string'
            ]);
        $result = $todo->addTask($task);

        return response()->json(["data" => $result]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task $task
     * @return TaskResource
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        $task = Task::with('todo')->findOrFail($task);
        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Task $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {

        request()->validate(['status' => [
            'required',
            Rule::in(['NEW', 'CAN', 'DON']),
        ],
        ]);

        $method = null;
        if (request('status') == 'NEW') {
            $result = $task->newed();
        }
        if (request('status') == 'CAN') {
            $result = $task->canceled();
        }
        if (request('status') == 'DON') {
            $task->todoDone();
            $result = $task->done();
        }


        return response()->json(["data" => array('message' => $result)]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $result = $task->delete();
        return response()->json(["data" => array('message' => $result)]);

    }
}
