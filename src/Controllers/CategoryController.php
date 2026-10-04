<?php

declare(strict_types=1);

final class CategoryController
{
    private const POSTS_PER_PAGE = 10;

    public function __construct(
        private CategoryRepository $categoryRepository,
        private PostRepository $postRepository,
        private Smarty\Smarty $smarty
    ) {
    }

    public function index(string $categoryName): void
    {
        $category = $this->categoryRepository->findByName($categoryName);

        if ($category === null) {
            $this->notFound();
            return;
        }

        $page = filter_input(
            INPUT_GET,
            'page',
            FILTER_VALIDATE_INT
        );

        $page = $page === false || $page === null
            ? 1
            : $page;

        $sort = $_GET['sort'] ?? 'date';
        $direction = strtoupper($_GET['direction'] ?? 'DESC');

        if (!in_array($sort, ['date', 'views'], true)) {
            $this->notFound();
            return;
        }

        if (!in_array($direction, ['ASC', 'DESC'], true)) {
            $this->notFound();
            return;
        }

        $totalPosts = $this->postRepository->countByCategory(
            (int) $category['id']
        );

        $totalPages = max(
            1,
            (int) ceil($totalPosts / self::POSTS_PER_PAGE)
        );

        if ($page < 1 || $page > $totalPages) {
            $this->notFound();
            return;
        }

        $offset = ($page - 1) * self::POSTS_PER_PAGE;

        $posts = $this->postRepository->getByCategory(
            (int) $category['id'],
            self::POSTS_PER_PAGE,
            $offset,
            $sort,
            $direction
        );

        $this->smarty->assign('category', $category);
        $this->smarty->assign('posts', $posts);
        $this->smarty->assign('page', $page);
        $this->smarty->assign('totalPages', $totalPages);
        $this->smarty->assign('sort', $sort);
        $this->smarty->assign('direction', $direction);
        $this->smarty->assign('title', $category['name']);

        $this->smarty->display('pages/category.tpl');
    }

    private function notFound(): void
    {
        http_response_code(404);

        $this->smarty->assign('title', '404');
        $this->smarty->display('pages/404.tpl');
    }
}