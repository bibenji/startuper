<?php

namespace View;

class ArticleView extends AbstractView
{	
    public function render($parameters)
    {	
        foreach ($parameters as $key => $value) {
            $$key = $value;
        }
        
        ob_start ();
?>

<main id="main-article">
	<div class="row">
		<div class="col-md-8">

			<div class="card">
				<div class="card-body">
					<h2><?= $article->getTitle() ?></h2>
					<hr />
					<div class="row">
						<div class="col-md-4">
							<?php foreach ($article->getCategories() as $category) { ?>								
								<span class="badge badge-secondary"><?= $category ?></span>
							<?php } ?>
						</div>
						<div class="col-md-4">
							<i class="far fa-calendar-alt"></i> <?= $article->getCreatedAt() ?>
						</div>
						<div class="col-md-4">
							<i class="far fa-comments"></i> <?= $totalComments ?> commentaire(s)
						</div>
					</div>
					<hr />
					<div class="row">
						<div class="col-md-12">
							<p>Résumé</p>
							<p><?= $article->getResume() ?></p>
						</div>
					</div>
					<hr />
					<div class="row">

						<div id="article-content" class="col-md-12">
							<img src="/data/articles/<?= $article->getPicture() ?>" />							
							<?= $article->getContent() ?>
						</div>
						
						<div class="col-md-12">								
								
<!-- 							<div class="author-description"> -->
<!-- 								<div class="row"> -->
<!-- 									<div class="col-md-2"> -->
<!-- 										<img src="https://source.unsplash.com/random/50x50" /> -->
<!-- 										<div class="text-center"> -->
<!-- 											<strong>John</strong> -->
<!-- 										</div> -->
<!-- 									</div> -->
<!-- 									<div class="col-md-10"> -->
<!-- 										<div> -->
<!-- 											<I>Lundi 15 Octobre à 01h10</I> -->
<!-- 										</div> -->
<!-- 										<div> -->
<!-- 											<p>Lorem ipsum dolor sit amet, consectetur adipiscing -->
<!-- 												elit. Donec molestie felis at orci placerat aliquet. Donec -->
<!-- 												pharetra tempor mauris a pretium. Aliquam eleifend dolor -->
<!-- 												ante, vitae condimentum orci sagittis a. Nunc scelerisque, -->
<!-- 												diam vel placerat mollis, dui nisi feugiat mauris, quis -->
<!-- 												bibendum diam lacus sed nisl. Sed a consectetur quam.</p> -->
<!-- 										</div> -->
<!-- 									</div> -->
<!-- 								</div> -->
<!-- 							</div> -->

<!-- 							<h4>Articles similaires</h4> -->
<!-- 							<div class="row"> -->
<!-- 								<div class="col"> -->
<!-- 									<img src="https://source.unsplash.com/random/50x50" -->
<!-- 										width="100%" /> Article -->
<!-- 								</div> -->
<!-- 								<div class="col"> -->
<!-- 									<img src="https://source.unsplash.com/random/50x50" -->
<!-- 										width="100%" /> Article -->
<!-- 								</div> -->
<!-- 								<div class="col"> -->
<!-- 									<img src="https://source.unsplash.com/random/50x50" -->
<!-- 										width="100%" /> Article -->
<!-- 								</div> -->
<!-- 								<div class="col"> -->
<!-- 									<img src="https://source.unsplash.com/random/50x50" -->
<!-- 										width="100%" /> Article -->
<!-- 								</div> -->
<!-- 								<div class="col"></div> -->
<!-- 							</div> -->
							
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col text-left">
<!-- 					<a href="">Plus récent</a> -->
				</div>
				<div class="col text-center">
					<a href="/blog">Retour</a>
				</div>
				<div class="col text-right">
<!-- 					<a href="">Plus ancien</a> -->
				</div>
			</div>

			<br />

			<div class="card">
				<div class="card-body">

					<h4><?= $totalComments ?> commentaire(s)</h4>
					
					<?php foreach ($article->getComments() as $comment) { ?>					
    					<div class="real-comment">
    						<strong><?= NULL !== $comment->getUser()->getUsername() ? $comment->getUser()->getUsername() : $comment->getPseudo() ?></strong> <I><?= $this->locale->getFullDate($comment->getDate()) ?></I>
    						<p><?= $comment->getComment() ?></p>
    					</div>
					<?php } ?>
					
					<?php if ($totalPages > 1) { ?>
    					<div class="text-center">
        					<?php for ($i = 1; $i <= $totalPages; $i++) { ?>
        						<a<?= ($i != $currentPage ? ' href="?page='.$i.'"' : '') ?>><?= $i ?></a>
        					<?php } ?>
    					</div>
					<?php } ?>
					
					<br />
					
					<div id="comment-zone">

						<?php if (!$userUsername) { ?>
							<h5>Connectez-vous pour laisser un commentaire</h5>
							<a href="/connexion">Connexion</a>
						<?php } else { ?>
							<h5>Laisser un commentaire</h5>
							<form method="post">
								<input type="hidden" name="token" value="<?= $token ?>" />								
								<input class="mb-2 form-control" disabled name="pseudo" placeholder="Pseudo" type="text" value="<?= $userUsername ?>" />
								<textarea rows="5" class="mb-2 form-control" name="comment">Ecrivez-ici votre commentaire.</textarea>
								<div class="mb-2">
									Ecrire les lettres <strong><?= $captcha ?></strong> dans l'ordre inverse :
									<input class="form-control" type="text" name="captcha" />
								</div>
								<input class="btn btn-default" type="reset" value="Effacer" />
								<input class="btn btn-success" name="submit" type="submit" value="Soumettre" />
							</form>
						<?php } ?>
						
					</div>
					
				</div>
			</div>
		</div>
		
		<div class="col-md-4">		
			<?php include(__DIR__.'/BlogMenu.php'); ?>
		</div>
	</div>
</main>

<?php
        $viewContent = ob_get_contents();
        ob_end_clean();        
        return $viewContent;
    }
}
