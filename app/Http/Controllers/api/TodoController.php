<?php

namespace App\Http\Controllers\api;

use App\Http\Resources\TodoResrouce;
use App\Http\Resources\UserResource;
use App\Todo;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EloquentBuilder;
use Illuminate\Validation\Rule;


class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return TodoResrouce
     */
    public function index(Request $request)
    {

        //todo validate status and title filters


        $todos = EloquentBuilder::to(
            Todo::class,
            $request->all()
        );

        /*
         * show current user todos
         *  return  $todos->with(['tasks','user'])->whereHas('user',function ($query){
             $query->where('api_token','b3b2268cda6e1e5a2f40e529253cc645a5181e253bace78cfdf9fe587891');
         })->get();*/


        return new TodoResrouce($todos->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
                'title' => 'required|string',
                'description' => 'required|string',
            ]
        );


        $result = Todo::create([
            'title' => request('title'),
            'description' => request('description'),
            'user_id' => auth()->id()
        ]);


        return response()->json(["data" => array('message' => $result)]);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Todo $todo
     * @return UserResource
     */
    public function show(Todo $todo)
    {

        /*    if ($todo->user_id!=auth()->id()){
            throw new AuthenticationException('Unauthenticated.');


        }*/
        $this->authorize('view', $todo);


        $todo = Todo::with('tasks')->findOrFail($todo);
        return new TodoResrouce($todo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Todo $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {

        request()->validate(['status' => [
            'required',
            Rule::in(['CAN']),],]);

        $method = null;

        if (request('status') == 'CAN') {
            $todo->canceled();
            $method = 'canceled';
        }


        $result = $todo->$method();
        return response()->json(["data" => array('message' => $result)]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Todo $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {

        if (count($todo->tasks) == 0) {
            $result = $todo->delete();


        } else {

            $result = "you can't delete todo that has a task";
        }


        return response()->json(["data" => array('message' => $result)]);


    }
}
