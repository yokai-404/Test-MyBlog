<?php

declare(strict_types=1);

final class PostController
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private PostRepository $postRepository,
        private Smarty\Smarty $smarty
    ) {
    }

    public function index(
        string $categoryName,
        int $postId
    ): void {
        $category = $this->categoryRepository->findByName($categoryName);

        if ($category === null) {
            $this->notFound();
            return;
        }

        $post = $this->postRepository->findById($postId);

        if ($post === null) {
            $this->notFound();
            return;
        }

        $belongsToCategory = false;

        foreach ($post['categories'] as $postCategory) {
            if ((int) $postCategory['id'] === (int) $category['id']) {
                $belongsToCategory = true;
                break;
            }
        }

        if (!$belongsToCategory) {
            $this->notFound();
            return;
        }

        $this->postRepository->incrementViews($postId);

        $post['views']++;

        $similarPosts = $this->postRepository->getSimilar(
            $postId,
            $post['categories']
        );

        $this->smarty->assign('post', $post);
        $this->smarty->assign('category', $category);
        $this->smarty->assign('similarPosts', $similarPosts);
        $this->smarty->assign('title', $post['title']);

        $this->smarty->display('pages/post.tpl');
    }

    private function notFound(): void
    {
        http_response_code(404);

        $this->smarty->assign('title', '404');
        $this->smarty->display('pages/404.tpl');
    }
}