<?php

namespace App\Observers;

use App\Result;
use App\ResultLog;

class ResultObserver
{
    /**
     * Handle the result "created" event.
     *
     * @param  \App\Result  $result
     * @return void
     */
    public function created(Result $result)
    {
        ResultLog::create([
            'result_id'=>$result->id,
            'change'=>json_encode($result),
            'by' => auth()->user()->id
        ]);
    }

    /**
     * Handle the result "updated" event.
     *
     * @param  \App\Result  $result
     * @return void
     */
    public function updated(Result $result)
    {
        ResultLog::create([
            'result_id'=>$result->id,
            'change'=>json_encode($result),
            'by' => auth()->user()->id
        ]);
    }

    /**
     * Handle the result "deleted" event.
     *
     * @param  \App\Result  $result
     * @return void
     */
    public function deleted(Result $result)
    {
        ResultLog::create([
            'result_id'=>$result->id,
            'change'=>json_encode($result),
            'by' => auth()->user()->id
        ]);
    }

    /**
     * Handle the result "restored" event.
     *
     * @param  \App\Result  $result
     * @return void
     */
    public function restored(Result $result)
    {
        //
    }

    /**
     * Handle the result "force deleted" event.
     *
     * @param  \App\Result  $result
     * @return void
     */
    public function forceDeleted(Result $result)
    {
        //
    }
}
