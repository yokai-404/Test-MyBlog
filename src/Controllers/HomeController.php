<?php

declare(strict_types=1);

final class HomeController
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private PostRepository $postRepository,
        private Smarty\Smarty $smarty
    ) {
    }

    public function index(): void
    {
        $categories = $this->categoryRepository->getAll();

        $categoryData = [];

        foreach ($categories as $category) {
            $posts = $this->postRepository->getLatestByCategory(
                (int) $category['id']
            );

            if ($posts === []) {
                continue;
            }

            $category['posts'] = $posts;
            $categoryData[] = $category;
        }

        $this->smarty->assign('categories', $categoryData);
        $this->smarty->assign('title', 'My Blog');

        $this->smarty->display('pages/home.tpl');
    }
}