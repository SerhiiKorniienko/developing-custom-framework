<?php

declare(strict_types=1);

if (! function_exists('app')) {
    function app(): \App\Core\Application
    {
        return \App\Core\Application::getInstance();
    }
}

if (! function_exists('dd')) {
    function dd($vars): void
    {
        echo '<pre>';
        if (is_array($vars)) {
            array_map(function ($element) {
                print_r($element);
            }, $vars);
        } else {
            print_r($vars);
        }
        echo '</pre>';
        exit();
    }
}