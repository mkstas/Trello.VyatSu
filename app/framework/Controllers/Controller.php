<?php declare(strict_types=1);

namespace Framework\Controllers;

use Framework\Http\Response;
use Framework\Http\View;

abstract class Controller
{
    protected function json(mixed $data, int $status = 200): Response
    {
        return Response::json($data, $status);
    }

    protected function html(string $body, int $status = 200): Response
    {
        return Response::html($body, $status);
    }

    protected function view(string $template, array $data = [], int $status = 200): Response
    {
        return $this->html(View::render($template, $data), $status);
    }

    protected function redirect(string $url, int $status = 302): Response
    {
        return Response::redirect($url, $status);
    }
}
