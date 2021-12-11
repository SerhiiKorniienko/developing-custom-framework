<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    public Request $request;

    public Response $response;

    protected array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
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
            Application::$app->controller = new $callback[0]();
            $callback[0] = Application::$app->controller;
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
        $layout = Application::$app->controller->getLayout();

        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";

        return ob_get_clean();
    }

    protected function getViewContent(string $view, array $params): string
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";

        return ob_get_clean();
    }
}