<?php

declare(strict_types=1);

final class Router
{
    public function dispatch(string $uri): array
    {
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';

        $path = trim($path, '/');

        if ($path === '') {
            return [
                'controller' => 'home',
                'params' => [],
            ];
        }

        $segments = array_map(
            'urldecode',
            explode('/', $path)
        );

        if (
            count($segments) === 2
            && $segments[0] === 'category'
        ) {
            return [
                'controller' => 'category',
                'params' => [
                    'category' => $segments[1],
                ],
            ];
        }

        if (
            count($segments) === 4
            && $segments[0] === 'category'
            && $segments[2] === 'post'
            && ctype_digit($segments[3])
        ) {
            return [
                'controller' => 'post',
                'params' => [
                    'category' => $segments[1],
                    'postId' => (int) $segments[3],
                ],
            ];
        }

        return [
            'controller' => '404',
            'params' => [],
        ];
    }
}