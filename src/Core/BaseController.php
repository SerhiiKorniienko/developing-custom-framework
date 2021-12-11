<?php

declare(strict_types=1);

namespace App\Core;

class BaseController
{
    protected string $layout = 'main';

    protected function render(string $view, array $params = [])
    {
        return Application::$app->router->renderView($view, $params);
    }

    protected function setLayout(string $layout)
    {
        $this->layout = $layout;
    }

    public function getLayout(): string
    {
        return $this->layout;
    }
}