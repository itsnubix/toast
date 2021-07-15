<?php

use Nubix\Toast\Toast;

if (! function_exists('toast')) {
    /**
     * Retrieve the Toast singleton and return it.
     * @param string|array|null $message
     * @return Toast
     */
    function toast(string | array | null $message = null) : Toast
    {
        $toast = app('toast');

        if (isset($message)) {
            $toast->message($message);
        }

        return $toast;
    }
}
