<?php

namespace App\Observers;

use App\Todo;

class TodoObserver
{

    /**
     * Listen to the Todos creating event.
     *
     * @param  \App\Todo $todo
     * @return void
     */
    public function creating(Todo $todo)
    {
        //make status new
        $todo->status = 'NEW';
    }


    /**
     * Listen to the Todos updated event.
     *
     * @param  \App\TOdo $user
     * @return void
     */
    public function updated(Todo $todo)
    {
        //
    }

}
