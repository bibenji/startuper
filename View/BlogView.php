<?php

namespace View;

class BlogView extends AbstractView
{
    public function render($parameters)
    {
        foreach ($parameters as $key => $value) {            
            $$key = $value;
        }
        
        ob_start ();
?>

<main id="main-blog">
    <div class="row">
    	<div class="col-md-8">
    		
    	<?php foreach ( $iterator as $article ) { ?>
    		<div class="card">
    			<div class="card-body">
    				<h2><?= $article->getTitle() ?></h2>
    				<hr />
    				<div class="row">
    					<div class="col-md-4">
    						<?php foreach ( $article->getCategories() as $category ) { ?>
    							<span class="badge badge-secondary"><?= $category ?></span>
    						<?php } ?>    				
    	    			</div>
    				<div class="col-md-4">
    					<i class="far fa-calendar-alt"></i> <?= $locale->getShortDate($article->getCreatedAt()) ?>
        			</div>
    				<div class="col-md-4">
    					<i class="far fa-comments"></i> <?= count($article->getComments()) ?> commentaire(s)
    				</div>
    			</div>
    			<hr />
    			<div class="row">
    				<div class="col-md-4">
    					<img src="/data/articles/<?= $article->getPicture() ?>" />
    				</div>
    				<div class="col-md-8">
    					<p><?= $article->getResume() ?></p>
    					<p class="text-right">
    						<a href="/article/<?= $article->getId() ?>">Lire la suite</a>
    					</p>
    				</div>
    			</div>
    		</div>
    	</div>
    	    
    	<?php } ?>
    				
    	<div class="row">
    		<div class="col text-left">
    			<?= $next ? '<a href="?page='.$next.'">Plus récents</a>' : '' ?>    			
    		</div>    		
    		<div class="col text-right">
    			<?= $prev ? '<a href="?page='.$prev.'">Plus anciens</a>' : '' ?>    			
    		</div>
    	</div>
    </div>

        <div class="col-md-4">
        	<?php include(__DIR__.'/BlogMenu.php'); ?>
        </div>
	</div>
</main>

<br />

<?php
        $viewContent = ob_get_contents ();
        ob_end_clean ();        
        return $viewContent;
    }
}
