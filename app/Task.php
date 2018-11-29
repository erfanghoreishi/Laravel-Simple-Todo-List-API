<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $hidden = ['user_id', 'todo_id'];
    protected $fillable = ['status','title','description','user_id'];

    public function todo()
    {
        return $this->belongsTo(Todo::class, 'todo_id');
    }

    public function todoDone()
    {
        return $this->todo()->update(['status' => 'DON']);
    }

    public function done()
    {
        return $this->update(['status' => 'DON']);

    }

    public function newed()
    {
        return $this->update(['status' => 'NEW']);

    }

    public function canceled()
    {
        return $this->update(['status' => 'CAN']);

    }


}
