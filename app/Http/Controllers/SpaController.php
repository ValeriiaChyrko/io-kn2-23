<?php

namespace App\Http\Controllers;

class SpaController extends Controller
{
    /**
     * Get the SPA view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function __invoke()
    {
        return view('spa');
    }
}
