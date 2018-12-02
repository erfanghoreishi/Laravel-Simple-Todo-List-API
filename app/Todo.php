<?php

namespace App;

use function GuzzleHttp\Promise\task;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    //


    //todo check for guarded variables
    protected $guarded = [];


    //has many tasks
    public function tasks()
    {
        return $this->hasMany(Task::class, 'todo_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function addTask($task)
    {

        // return $this->user_id;

        return $this->tasks()->create([
            'status' => $this->status,
            'user_id' => $this->user_id,
            'title' => $task['title'],
            'description' => $task['description']
        ]);
    }

    public function tasksCanceled()
    {
        return $this->tasks()->update(['status' => 'CAN']);
    }


    public function canceled()
    {
        $this->tasksCanceled();
        return $this->update(['status' => 'CAN']);
    }


}
