<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    protected array $routes = [];

    private BaseController $controller;

    public function __construct(
        private Container $container,
        public Request $request,
        public Response $response
    ) {
    }

    public function get(string $path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post(string $path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }


    public function resolve(): mixed
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;

        if (false === $callback) {
            $this->response->setStatusCode(404);
            return $this->renderContent('Whoops! Page not found!');
        }

        if (is_string($callback)) {
            return $this->renderView($callback);
        }

        if (is_array($callback)) {
            $this->controller = $this->container->get($callback[0]);
            $callback[0] = $this->controller;
        }

        return call_user_func($callback, $this->request);
    }

    public function renderView(string $view, array $params = []): string
    {
        $layoutContent = $this->getLayoutContent();
        $viewContent = $this->getViewContent($view, $params);

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function renderContent(string $content): string
    {
        $layoutContent = $this->getLayoutContent();

        return str_replace('{{content}}', $content, $layoutContent);
    }

    protected function getLayoutContent(): string
    {
        $layout = isset($this->controller) ? $this->controller->getLayout() : 'main';

        ob_start();
        include_once app()->getRootPath() . "/views/layouts/$layout.php";

        return ob_get_clean();
    }

    protected function getViewContent(string $view, array $params): string
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include_once app()->getRootPath() . "/views/$view.php";

        return ob_get_clean();
    }
}
