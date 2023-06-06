<?php

namespace App\Observers;

use App\Models\Item;

class ItemObserver    //TODO: Create methods
{
    /**
     * Handle the Item "created" event.
     *
     * @param Item $item
     * @return bool
     */
    public function created(Item $item): bool
    {
        if($item->part_of) {
            if(!$item->parent->has_parts) {
                $item->parent->update(['has_parts' => true]);
            }
        }

        $isItemParentNotInSameInvoice = !$item->parent || $item->invoice_id != $item->parent->invoice_id;

        if($item->price and $isItemParentNotInSameInvoice) {
            $item->invoice->total_sum += $item->price;
            $item->invoice->save();
        }

        return true;
    }

    /**
     * Handle the Item "updated" event.
     *
     * @param Item $item
     * @return bool
     */
    public function updated(Item $item): bool
    {
        if($item->isDirty('part_of')) {
            if($item->getOriginal('part_of')) {
                $previousParent = Item::find($item->getOriginal('part_of'));

                $previousParentOtherPartsCount = $previousParent->parts()
                    ->count();

                if($previousParentOtherPartsCount == 0) {
                    $previousParent->update(['has_parts' => false]);
                }
            }

            if($item->part_of) {
                if(!$item->parent->has_parts) {
                    $item->parent->update(['has_parts' => true]);
                }
            }
        }


        $isItemParentNotInSameInvoice = !$item->parent || $item->invoice_id != $item->parent->invoice_id;

        if($item->isDirty('price') and $isItemParentNotInSameInvoice) {

            $priceDelta = ($item->price ?? 0) - ($item->getOriginal('price') ?? 0);
            $item->invoice->total_sum += $priceDelta;

            $item->invoice->save();
        }

        $this->updatePartsAndLicensesOwnerAndDepartment($item);

        //TODO: Change license owner on item update and transfer
        //TODO:Change owner and department on update and transfer
        //If item in another invoice dont change owner

        return true;
    }

    /**
     * Handle the Item "deleting" event.
     *
     * @param Item $item
     * @return void
     */
    public function deleting(Item $item)
    {
        $isItemParentNotInSameInvoice = !$item->parent || $item->invoice_id != $item->parent->invoice_id;

        if($item->price and $isItemParentNotInSameInvoice) {
            $item->invoice->total_sum -= $item->price;
            $item->invoice->save();
        }

        if($item->parent) {
            $parentOtherPartsCount = $item->parent->parts()->where('id', '!=', $item->id)->count();
            if($parentOtherPartsCount == 0) {
                $item->parent->update(['has_parts' => false]);
            }
        }

        $this->deleteItemPartsAndLicenses($item);
        $this->removeInventoryNumber($item);
    }

    private function updatePartsAndLicensesOwnerAndDepartment(Item $item)
    {
        $isDepartmentChanged = $item->isDirty('department_id');
        $isOwnerChanged = $item->isDirty('owner_id');

        if($isDepartmentChanged or $isOwnerChanged) {
            foreach ($item->parts as $part) {
                if($isDepartmentChanged) {
                    $part->department_id = $item->department_id;
                }
                if($isOwnerChanged and $part->invoice_id == $item->invoice_id) {
                    $part->owner_id = $item->owner_id;
                }

                $part->save();
            }
        }

        if($isOwnerChanged) {
            foreach ($item->licenses as $license) {
                if($license->invoice_id == $item->invoice_id) {
                    $license->owner_id = $item->owner_id;

                    $license->save();
                }
            }
        }
    }

    /**
     * Deletes item parts and licenses.
     *
     * @param Item $item
     * @return void
     */
    private function deleteItemPartsAndLicenses(Item $item)
    {
        foreach ($item->parts as $part) {    // FIXME
            $part->delete();
        }
        foreach ($item->licenses as $license) {
            $license->delete();
        }
    }

    /**
     * Removes item inventory number and write it as a comment
     *
     * @param Item $item
     * @return void
     */
    private function removeInventoryNumber(Item $item)
    {
        if($item->inventory_number) {
            $oldInventoryNumberPrependText = 'Старий номер - ';    //TODO: Refactor

            $item->comment .= ($oldInventoryNumberPrependText . $item->inventory_number);
            $item->inventory_number = null;

            $item->save();
        }
    }
}
