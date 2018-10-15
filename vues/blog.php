<?php

ob_start();

foreach ($iterator as $article) {	
	$categories = explode(',', $article->getCategories());
	
?>

	<div class="card">
    	<div class="card-body">    		
    		<h2><?php echo $article->getTitle() ?></h2>
    		<hr />
    		<div class="row">
    			<div class="col-md-4">
					<?php
						foreach ($categories as $category) {
							?>
								<span class="badge badge-secondary"><?php echo $category ?></span>
							<?php 
						}
    				?>    				
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
    			<div class="col-md-4">
    				<img src="https://source.unsplash.com/random/300x300" />
    			</div>
    			<div class="col-md-8">
    				<p><?php echo $article->getResume() ?></p>
    				<p class="text-right"><a href="article.html">Lire la suite</a></p>	
    			</div>
    		</div>
    	</div>    		
    </div>


<?php

}

$content = ob_get_contents();
ob_end_clean();

?>