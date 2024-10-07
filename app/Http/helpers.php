<?php

if (! function_exists('core')) {
    /**
     * Core helper.
     *
     * @return \App\Classes\Core
     */
    function core()
    {
        return app()->make(\App\Classes\Core::class);
    }
}