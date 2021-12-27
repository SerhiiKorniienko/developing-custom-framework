<?php

declare(strict_types=1);

namespace App\Core;

class Response
{
    public const MOVED_PERMANENTLY = 301;
    public const FOUND = 302;
    public const SEE_OTHER = 303;
    public const TEMPORARY_REDIRECT = 307;
    public const PERMANENT_REDIRECT = 308;

    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect(string $url, int $code = self::MOVED_PERMANENTLY)
    {
        header(sprintf('Location: %s', $url), true, $code);
    }
}
