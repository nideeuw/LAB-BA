<?php

class Router
{
    protected $routes = [];
    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function add($uri, $controller)
    {
        $this->routes['/' . trim($uri, '/')] = $controller;
    }

    public function dispatch($uri)
    {
        // Normalize URI
        $uri = '/' . trim($uri, '/');

        // Handle empty URI (homepage)
        if ($uri === '/' || $uri === '') {
            if (isset($this->routes['/'])) {
                $uri = '/';
            }
        }

        $matchedRoute = null;
        $params = [];

        // Try to match route with parameters
        foreach ($this->routes as $route => $controller) {
            // Convert route pattern to regex
            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([^/]+)', $route);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                $matchedRoute = $controller;
                array_shift($matches); // Remove full match
                $params = $matches;
                break;
            }
        }

        // If no match found, try exact match
        if (!$matchedRoute && isset($this->routes[$uri])) {
            $matchedRoute = $this->routes[$uri];
        }

        // 404 if still no match
        if (!$matchedRoute) {
            header("HTTP/1.0 404 Not Found");
            echo "<!DOCTYPE html>
                    <html lang='en'>
                    <head>
                        <meta charset='UTF-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        <title>404 Not Found</title>
                        <style>
                            body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
                            h1 { font-size: 48px; color: #333; }
                            p { font-size: 18px; color: #666; }
                            code { background: #f4f4f4; padding: 2px 5px; border-radius: 3px; }
                        </style>
                    </head>
                    <body>
                        <h1>404 - Not Found</h1>
                        <p>The requested URL <code>" . htmlspecialchars($uri) . "</code> was not found on this server.</p>
                        <p><a href='/cms/dashboard'>Back to Dashboard</a></p>
                    </body>
                    </html>";
            die();
        }

        // Parse controller string
        $parts = explode('/', $matchedRoute);
        $modul = array_shift($parts);           // e.g., 'cms'
        $controllerName = ucfirst(array_shift($parts)) . 'Controller'; // e.g., 'MenuController'
        $methodName = array_shift($parts);      // e.g., 'index'

        // Build controller path
        $controllerPath = APP_PATH . "{$modul}/controllers/{$controllerName}.php";

        // Check if controller file exists
        if (!file_exists($controllerPath)) {
            header("HTTP/1.0 404 Not Found");
            echo "<!DOCTYPE html>
                    <html lang='en'>
                    <head>
                        <meta charset='UTF-8'>
                        <title>404 Controller Not Found</title>
                        <style>
                            body { font-family: Arial, sans-serif; padding: 50px; }
                            h1 { color: #d9534f; }
                            code { background: #f4f4f4; padding: 2px 5px; border-radius: 3px; }
                        </style>
                    </head>
                    <body>
                        <h1>404 - Controller File Not Found</h1>
                        <p>Controller file: <code>{$controllerPath}</code></p>
                        <p>Expected structure: <code>app/{$modul}/controllers/{$controllerName}.php</code></p>
                        <p><a href='/cms/dashboard'>Back to Dashboard</a></p>
                    </body>
                    </html>";
            die();
        }

        // Require controller file
        require_once $controllerPath;

        // Check if class exists
        if (!class_exists($controllerName)) {
            header("HTTP/1.0 404 Not Found");
            die("404 - Controller class not found: {$controllerName}");
        }

        // Instantiate controller
        $controllerInstance = new $controllerName();

        // Check if method exists
        if (!method_exists($controllerInstance, $methodName)) {
            header("HTTP/1.0 404 Not Found");
            echo "<!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <title>404 Method Not Found</title>
                    <style>
                        body { font-family: Arial, sans-serif; padding: 50px; }
                        h1 { color: #d9534f; }
                        code { background: #f4f4f4; padding: 2px 5px; border-radius: 3px; }
                    </style>
                </head>
                <body>
                    <h1>404 - Method Not Found</h1>
                    <p>Method: <code>{$controllerName}::{$methodName}()</code></p>
                    <p>Available methods: " . implode(', ', get_class_methods($controllerInstance)) . "</p>
                    <p><a href='/cms/dashboard'>Back to Dashboard</a></p>
                </body>
                </html>";
            die();
        }

        // Call controller method with connection and parameters
        $methodParams = array_merge([$this->conn], $params);
        call_user_func_array([$controllerInstance, $methodName], $methodParams);
    }
}
