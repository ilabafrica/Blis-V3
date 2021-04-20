<?php

namespace App\Observers;

use App\Models\Result;
use App\Models\ResultLog;

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
        $user = auth()->user();
        if ($user) {
            $by = $user->id;
        } else {
            $by = 'system';
        }
        ResultLog::create([
            'result_id'=>$result->id,
            'change'=>json_encode($result),
            'by' => $by,
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
        $user = auth()->user();
        if ($user) {
            $by = $user->id;
        } else {
            $by = 'system';
        }
        ResultLog::create([
            'result_id'=>$result->id,
            'change'=>json_encode($result),
            'by' => $by,
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
        $user = auth()->user();
        if ($user) {
            $by = $user->id;
        } else {
            $by = 'system';
        }
        ResultLog::create([
            'result_id'=>$result->id,
            'change'=>json_encode($result),
            'by' => $by,
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
