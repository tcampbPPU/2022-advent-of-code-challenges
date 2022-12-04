<?php

use Illuminate\Support\Facades\Http;

// ! SETUP
$problemUrl = 'https://adventofcode.com/2022/day/4/input';
$sessionKey = $_ENV['SESSION_KEY'];
$response = Http::withOptions(['verify' => false])
    ->withCookies(['session' => $sessionKey], 'adventofcode.com')
    ->withUserAgent('Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36')
    ->get($problemUrl);
$input = $response->body();
$input = explode("\n", $input);
$input = array_filter($input, fn($line) => $line !== '');

$data = collect($input)
    ->map(function ($list) {
        [$one, $two] = explode(',', $list);
        $one = explode('-', $one);
        $one = range($one[0], $one[1]);
        $two = explode('-', $two);
        $two = range($two[0], $two[1]);

        if ($two[0] >= $one[0] && $two[0] <= end($one) && end($two) <= end($one)) {
            return 1;
        }

        if ($one[0] >= $two[0] && $one[0] <= end($one) && end($one) <= end($two)) {
            return 1;
        } 
    })
    ->sum(fn ($val) => $val);
dd("Total score is: {$data}"); // 542