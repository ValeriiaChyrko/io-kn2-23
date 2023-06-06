<?php

if (! function_exists('can')) {
    /**
     * Check user for permission using auth()->user()->can() method;
     *
     * @param string $permission Permission code (name).
     * @return bool Is user have a provided permission.
     */
    function can(string $permission): bool
    {
        return auth()->check() ? auth()->user()->can($permission) : false;
    }
}
