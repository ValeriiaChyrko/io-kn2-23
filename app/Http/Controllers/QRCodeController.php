<?php

namespace App\Http\Controllers;

class QRCodeController extends Controller
{
    /**
     * Show the page with the information about item.
     *
     * @param $itemId
     * @return \Illuminate\Contracts\View\View
     */
    public function showItem($itemId)
    {
        return view('inventory.admin.items.show', compact('itemId'));
    }
}
