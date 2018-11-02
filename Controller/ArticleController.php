<?php

namespace Controller;

use Database\{Connection, Finder, Paginate, Service\ArticleService, Service\CommentService};
use Engine\Request;
use Entity\Comment;

class ArticleController extends BaseController
{
    const MAX_COMMENTS_PER_PAGE = 10;
    
    public function handle($articleId)
    {   
        $commentService = new CommentService($this->connection);
        
        $currentPage = $this->request->getParam('page') ?? 1;
        $totalComments = $commentService->getTotalCommentsForArticle($articleId);
        $totalPages = ceil(((int) $totalComments) / self::MAX_COMMENTS_PER_PAGE);               
        
        $articleService = new ArticleService($this->connection);        
        $article = $articleService->fetchByIdWithComments(
            $articleId,
            ($currentPage-1)*self::MAX_COMMENTS_PER_PAGE,
            self::MAX_COMMENTS_PER_PAGE
        );
        
        $formValid = function(Request $request) {
            if (
                '' != $this->request->getParam('pseudo')
                && '' != $this->request->getParam('comment')
                && 'Ecrivez-ici votre commentaire.' != $this->request->getParam('comment')
            ) {
                return TRUE;
            }
            return FALSE;            
        };
                        
        if (Request::METHOD_POST === $this->request->getMethod() && $formValid($this->request)) {            
            $sessToken = $this->session->getToken() ?? 1;
            $postToken = $this->request->getParam('token') ?? 2;
//             $this->session->setToken(NULL);
            
            if ($sessToken != $postToken) {                
                $this->addMessage('Erreur : token mismatch');
            } else {                
                $comment = Comment::arrayToEntity($this->request->getParams(), (new Comment()));
                $comment->setArticle($article);
                $commentService->save($comment);
                $article = $articleService->fetchByIdWithComments(
                    $articleId,
                    ($currentPage-1)*self::MAX_COMMENTS_PER_PAGE,
                    self::MAX_COMMENTS_PER_PAGE
                );
            }
        }
        
        $token = urlencode(base64_encode((random_bytes(32))));
        $this->session->setToken($token);        
        
        $countByCategories = $articleService->countByCategories();
        $lastArticles = $articleService->getLastArticles();        
                
        $this->renderView('View\ArticleView', [
            'article' => $article,
            'countByCategories' => $countByCategories,
            'lastArticles' => $lastArticles,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'token' => $token,
            'totalComments' => $totalComments,
        ]);
    }
}
