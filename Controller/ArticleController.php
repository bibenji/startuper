<?php

namespace Controller;

use Database\{Connection, Finder, Paginate, Service\ArticleService, Service\CommentService};
use Engine\Request;
use Entity\Comment;
use Engine\Captcha\Reverse;

class ArticleController extends BaseController
{
    const MAX_COMMENTS_PER_PAGE = 10;
    const DEFAULT_PAGE = 1;

    const FAKE_SESSION_TOKEN = 1;
    const FAKE_POST_TOKEN = 2;
    
    public function handle($articleId)
    {           
        $commentService = new CommentService($this->connection);
        
        $currentPage = $this->request->getParam('page') ?? self::DEFAULT_PAGE;
        $totalComments = $commentService->getTotalCommentsForArticle($articleId);
        $totalPages = ceil(((int) $totalComments) / self::MAX_COMMENTS_PER_PAGE);               
        
        $articleService = new ArticleService($this->connection);        
        $article = $articleService->fetchByIdWithComments(
            $articleId,
            ($currentPage - 1) * self::MAX_COMMENTS_PER_PAGE,
            self::MAX_COMMENTS_PER_PAGE
        );

        $image = '';
        $label = '';
        $phrase = $this->session->getPhrase() ?? '';

        $formValid = function(Request $request) use ($phrase) {
            if (                
                '' != $this->request->getParam('comment')
                && 'Ecrivez-ici votre commentaire.' != $this->request->getParam('comment')
                // && '' != $this->request->getParam('pseudo')                
                && $this->request->getParam('captcha') === $phrase
            ) {
                return TRUE;
            }
            
            $this->addMessage('Erreur : Formulaire invalide');
            return FALSE;            
        };

        if (Request::METHOD_POST === $this->request->getMethod() && $formValid($this->request)) {            
            $sessToken = $this->session->getToken() ?? self::FAKE_SESSION_TOKEN;
            $postToken = $this->request->getParam('token') ?? self::FAKE_POST_TOKEN;
//             $this->session->setToken(NULL);

            if ($sessToken != $postToken) {                
                $this->addMessage('Erreur : les tokens de sécurité ne correspondent pas');
            } else if ($this->session->getUserId() === NULL) {
                $this->addMessage('Erreur : vous devez être connecté pour pouvoir eneregistrer un commentaire');
            } else {      
                $comment = Comment::arrayToEntity($this->request->getParams(), (new Comment()));
                $comment->setArticle($article);
                $comment->setUser($this->session->getUserId());
                $commentService->save($comment);
                $article = $articleService->fetchByIdWithComments(
                    $articleId,
                    ($currentPage - 1) * self::MAX_COMMENTS_PER_PAGE,
                    self::MAX_COMMENTS_PER_PAGE
                );
            }
        }
        
        $this->setCaptcha($phrase, $label, $image);
        
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
            'userUsername' => $this->session->getUserUsername(),            
            'captcha' => $image,
        ]);
    }
    
    private function setCaptcha(&$phrase, &$label, &$image)
    {
        $captcha = new Reverse();
        $phrase = $captcha->getPhrase();
        $label = $captcha->getLabel();
        $image = $captcha->getImage();
        $this->session->setPhrase($phrase);
    }
}
