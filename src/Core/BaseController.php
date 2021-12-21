<?php

declare(strict_types=1);

namespace App\Core;

class BaseController
{
    protected string $layout = 'main';

    public function __construct(
        protected Container $container,
        protected Request $request,
        protected Response $response
    ) {
    }

    protected function render(string $view, array $params = []): string
    {
        return app()->router->renderView($view, $params);
    }

    protected function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    public function getLayout(): string
    {
        return $this->layout;
    }
}
