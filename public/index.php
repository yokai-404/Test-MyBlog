<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../src/Database/Connection.php';
require_once __DIR__ . '/../src/Router/Router.php';

require_once __DIR__ . '/../src/Repositories/CategoryRepository.php';
require_once __DIR__ . '/../src/Repositories/PostRepository.php';

require_once __DIR__ . '/../src/Controllers/HomeController.php';
require_once __DIR__ . '/../src/Controllers/CategoryController.php';
require_once __DIR__ . '/../src/Controllers/PostController.php';

$smarty = require __DIR__ . '/../config/smarty.php';

$pdo = Connection::get();

$categoryRepository = new CategoryRepository($pdo);
$postRepository = new PostRepository($pdo);

$router = new Router();

$route = $router->dispatch($_SERVER['REQUEST_URI']);

switch ($route['controller']) {
    case 'home':
        $controller = new HomeController(
            $categoryRepository,
            $postRepository,
            $smarty
        );

        $controller->index();
        break;

    case 'category':
        $controller = new CategoryController(
            $categoryRepository,
            $postRepository,
            $smarty
        );

        $controller->index(
            $route['params']['category']
        );
        break;

    case 'post':
        $controller = new PostController(
            $categoryRepository,
            $postRepository,
            $smarty
        );

        $controller->index(
            $route['params']['category'],
            $route['params']['postId']
        );
        break;

    default:
        http_response_code(404);

        $smarty->assign('title', '404');
        $smarty->display('pages/404.tpl');
        break;
}