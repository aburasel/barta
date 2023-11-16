<?php

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

if (!function_exists("displayAlert")) {
    function displayAlert()
    {
        if (Session::has('message')) {
            list($type, $message) = explode('|', Session::get('message'));

            if ($type == 'error') {
                $type = 'red';
            } else if ($type == 'success') {
                $type = 'green';
            } else {
                $type = 'yellow';
            }

            return sprintf('<div class="p-4 mb-4 text-sm text-%s-800 rounded-lg bg-%s-50 dark:bg-gray-800 dark:text-%s-400" role="alert">%s</div>', $type, $type, $type, $message);
        }

        return '';
    }
}

if (!function_exists("timeDifferenceInWord")) {
    function timeDifferenceInWord(String $startTime)
    {
        $startTime = Carbon::parse($startTime);
        $endTime = Carbon::parse(now());
        return $totalDuration = $startTime->diffForHumans($endTime, CarbonInterface::DIFF_RELATIVE_TO_NOW);
    }
}

if (!function_exists("wrapHashTagsByUrl")) {
    function wrapHashTagsByUrl(String $post)
    {
        if (Str::contains($post, '#')) {
            return Str::of($post)->replaceMatches(pattern: '/#(\w+)/',
                replace: function (array $matches){
                    return '<a href="'.route("feed.tags",str_replace('#','',$matches[0],)).'" class="text-black font-semibold hover:underline">' . $matches[0] . '</a>';
                }
            );
        }else{
            return $post;
        }

    }
}
