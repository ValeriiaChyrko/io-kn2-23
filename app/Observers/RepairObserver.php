<?php

namespace App\Observers;

use App\Models\Repair;
use App\Models\Status;

class RepairObserver
{
    /**
     * Handle the Repair "created" event.
     *
     * @param Repair $repair
     * @return bool
     */
    public function created(Repair $repair): bool
    {
        $repair->item->update([
            'status_id' => Status::STATUS_REPAIRING
        ]);

        return true;
    }

    /**
     * Handle the Repair "deleting" event.
     *
     * @param Repair $repair
     * @return bool
     */
    public function deleting(Repair $repair): bool
    {
        if(! $repair->is_deletable) {
            return false;
        }

        return true;
    }

    /**
     * Handle the Repair "deleted" event.
     *
     * @param Repair $repair
     * @return bool
     */
    public function deleted(Repair $repair): bool
    {
        if($repair->item->status_id == Status::STATUS_REPAIRING) {
            $repair->item->update([
                'status_id' => Status::STATUS_IN_USE
            ]);
        }

        return true;
    }
}
