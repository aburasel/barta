<?php

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

if (! function_exists('displayAlert')) {
    function displayAlert()
    {
        if (Session::has('message')) {
            [$type, $message] = explode('|', Session::get('message'));

            if ($type == 'error') {
                $type = 'red';
            } elseif ($type == 'success') {
                $type = 'green';
            } else {
                $type = 'yellow';
            }

            return sprintf('<div class="p-4 mb-4 text-sm text-%s-800 rounded-lg bg-%s-50 dark:bg-gray-800 dark:text-%s-400" role="alert" >%s</div>', $type, $type, $type, $message);
        }

        return '';
    }
}

if (! function_exists('displayToast')) {
    function displayToast()
    {
        if (Session::has('message')) {
            [$type, $message] = explode('|', Session::get('message'));

            if ($type == 'error') {
                $type = 'red';
            } elseif ($type == 'success') {
                $type = 'green';
            } else {
                $type = 'yellow';
            }

            return sprintf('<p x-data="{ show: true }" class="dark:text-%s-400" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
            class="text-sm text-gray-600">%s</p>', $type, $message);
        }

        return '';
    }
}

if (! function_exists('timeDifferenceInWord')) {
    function timeDifferenceInWord(string $startTime)
    {
        $startTime = Carbon::parse($startTime);
        $endTime = Carbon::parse(now());

        return $totalDuration = $startTime->diffForHumans($endTime, CarbonInterface::DIFF_RELATIVE_TO_NOW);
    }
}

if (! function_exists('wrapHashTagsByUrl')) {
    function wrapHashTagsByUrl(string $post)
    {
        if (Str::contains($post, '#')) {
            return Str::of($post)->replaceMatches(pattern: '/#(\w+)/',
                replace: function (array $matches) {
                    //echo '<pre>';var_dump($matches);
                    //return '<a href="'.route('feed.tags', str_replace('#', '', $matches[0])).'" class="text-black font-semibold hover:underline">'.$matches[0].'</a>';
                    return '<b " class="text-black font-semibold hover:underline">'.$matches[0].'</b>';
                }
            );
        } else {
            return $post;
        }

    }
}
