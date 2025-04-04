<?php

namespace Seraph;

use PDOException;

class EntryPoint
{
    /**
     * Class constructor.
     */
    public function __construct(private $website)
    {
    }

    public function run(string $uri, string $method)
    {
        try {
            ///
            $this->checkUri(uri: $uri);

            if ($uri == '') {
                $uri = $this->website->getDefaultRoute();
            }

            $route = explode(separator: '/', string: $uri);

            $controllerName = array_shift(array: $route);
            $action = array_shift(array: $route);

            if ($method === 'POST') {
                $action .= 'Submit';
            }

            $controller = $this->website->getController($controllerName);

            ///
            if (is_callable(value: [$controller, $action])) {
                $page = $controller->$action(...$route);

                $title = $page['title'];

                $variables = $page['variables'] ?? [];

                $output = $this->loadTemplate(templateFileName: $page['template'], variables: $variables);
            } else {
                http_response_code(404);
                $title = 'Not found';
                $output = 'Sorry, the page you are looking for could not be found.';
            }

        } catch (PDOException $e) {
            $title = 'An error has occurred';
            $output = 'Database error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
        }

        include __DIR__ . '/../templates/layout.html.php';
    }

    private function loadTemplate($templateFileName, $variables = [])
    {
        extract(array: $variables);

        ob_start();

        include __DIR__ . "/../templates/" . $templateFileName;

        return ob_get_clean();
    }

    private function checkUri($uri)
    {
        if ($uri != strtolower(string: $uri)) {
            http_response_code(response_code: 301);
            header(header: 'location: ' . strtolower(string: $uri));
        }
    }


}