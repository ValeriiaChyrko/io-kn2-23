<?php

namespace App\Observers;

use App\Models\License;

class LicenseObserver
{
    /**
     * Handle the License "created" event.
     *
     * @param License $license
     * @return bool
     */
    public function created(License $license): bool
    {
        $isLicenseItemNotInSameInvoice = !$license->item || $license->invoice_id != $license->item->invoice_id;

        if($license->price and $isLicenseItemNotInSameInvoice) {
            $license->invoice->total_sum += $license->price;
            $license->invoice->save();
        }

        return true;
    }

    /**
     * Handle the License "updated" event.
     *
     * @param License $license
     * @return bool
     */
    public function updated(License $license): bool
    {
        $isLicenseItemNotInSameInvoice = !$license->item || $license->invoice_id != $license->item->invoice_id;

        if($license->isDirty('price') and $isLicenseItemNotInSameInvoice) {
            $priceDelta = ($license->price ?? 0) - ($license->getOriginal('price') ?? 0);
            $license->invoice->total_sum += $priceDelta;

            $license->invoice->save();
        }


        return true;
    }

    /**
     * Handle the License "deleting" event.
     *
     * @param License $license
     * @return void
     */
    public function deleting(License $license)
    {
        $isLicenseItemNotInSameInvoice = !$license->item || $license->invoice_id != $license->item->invoice_id;

        if($license->price and $isLicenseItemNotInSameInvoice) {
            $license->invoice->total_sum -= $license->price;
            $license->invoice->save();
        }
    }
}
