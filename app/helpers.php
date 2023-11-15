<?php

use Illuminate\Support\Facades\Session;

if (!function_exists("displayAlert")) {
    function displayAlert()
    {
        if (Session::has('message')) {
            list($type, $message) = explode('|', Session::get('message'));

            if ($type == 'error') {
                $type = 'red';
            } else if ($type == 'success') {
                $type = 'green';
            } else{
                $type = 'yellow';
            }

            return sprintf('<div class="p-4 mb-4 text-sm text-%s-800 rounded-lg bg-%s-50 dark:bg-gray-800 dark:text-%s-400" role="alert">%s</div>', $type,$type,$type, $message);
        }

        return '';
    }
}

if (!function_exists("timeDifferenceInWord")) {
    function timeDifferenceInWord()
    {
        if (Session::has('message')) {
            list($type, $message) = explode('|', Session::get('message'));

            if ($type == 'error') {
                $type = 'red';
            } else if ($type == 'success') {
                $type = 'green';
            } else{
                $type = 'yellow';
            }

            return sprintf('<div class="p-4 mb-4 text-sm text-%s-800 rounded-lg bg-%s-50 dark:bg-gray-800 dark:text-%s-400" role="alert">%s</div>', $type,$type,$type, $message);
        }

        return '';
    }
}