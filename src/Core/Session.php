<?php

declare(strict_types=1);

namespace App\Core;

class Session
{
    protected const FLASH_KEY = 'flash_messages';

    public function __construct()
    {
        session_start();

        foreach ($messages = $this->getAllFlashMessages() as &$flashMessage) {
            $flashMessage['removed'] = true;
        }

        $_SESSION[self::FLASH_KEY] = $messages;
    }

    public function __destruct()
    {
        foreach ($this->getAllFlashMessages() as $key => $flashMessage) {
            if ($flashMessage['removed']) {
                unset($_SESSION[self::FLASH_KEY][$key]);
            }
        }
    }

    public function setFlash(string $key, string $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'message' => $message,
            'removed' => false,
        ];
    }

    public function getFlash(string $key): ?string
    {
        return $_SESSION[self::FLASH_KEY][$key]['message'] ?? null;
    }

    public function getAllFlashMessages(): array
    {
        return $_SESSION[self::FLASH_KEY] ?? [];
    }
}
