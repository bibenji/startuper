<?php

namespace View;

class ArticleView implements ViewInterface
{
    public function render($parameters)
    {
        $article = $parameters['article'];
        $countByCategories = $parameters['countByCategories'];
        $lastArticles = $parameters['lastArticles'];
        
        ob_start ();
?>

<main id="main-article">
	<div class="row">
		<div class="col-md-8">

			<div class="card">
				<div class="card-body">
					<h2><?php echo $article->getTitle() ?></h2>
					<hr />
					<div class="row">
						<div class="col-md-4">
							<?php foreach ($article->getCategories() as $category) { ?>								
								<span class="badge badge-secondary"><?php echo $category ?></span>
							<?php } ?>
						</div>
						<div class="col-md-4">
							<i class="far fa-calendar-alt"></i> <?php echo $article->getCreatedAt() ?>
						</div>
						<div class="col-md-4">
							<i class="far fa-comments"></i> 0 comments
						</div>
					</div>
					<hr />
					<div class="row">
						<div class="col-md-12">
							<p>Résumé</p>
							<p><?php echo $article->getResume() ?></p>
						</div>
					</div>
					<hr />
					<div class="row">

						<div id="article-content" class="col-md-12">
							<img src="https://source.unsplash.com/random/300x300" />							
							<?php echo $article->getContent() ?>
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
					<a href="">Plus récent</a>
				</div>
				<div class="col text-center">
					<a href="/blog">Retour</a>
				</div>
				<div class="col text-right">
					<a href="">Plus ancien</a>
				</div>
			</div>

			<br />

			<div class="card">
				<div class="card-body">

					<h4><?php echo count($article->getComments()) ?> commentaire(s)</h4>
					
					<?php foreach ($article->getComments() as $comment) { ?>					
    					<div class="real-comment">
    						<strong><?php echo $comment->getUser()->getUsername() ?></strong> <I><?php echo $comment->getDate() ?></I>
    						<p><?php echo $comment->getComment() ?></p>
    					</div>
					<?php } ?>
					
					<div id="comment-zone">
						<h5>Laisser un commentaire</h5>
						<input class="mb-2 form-control" type="text" placeholder="Pseudo" />
						<textarea rows="5" class="mb-2 form-control">Ecrivez-ici votre commentaire.</textarea>
						<input class="btn btn-default" type="reset" value="Effacer" /> <input
							class="btn btn-success" type="submit" value="Soumettre" />
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
