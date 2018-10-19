<?php

namespace View;

class BlogView implements ViewInterface
{
	public function render($parameters)
	{	
	    
		$iterator = $parameters['iterator'];			
		
		ob_start();
?>
    	
<div style="height: 75px;"></div>  	
      		
<!-- <h1 class="text-center">Blog</h1> -->

<main>        
	<div class="row">
		<div class="col-md-8">
		
		<?php		
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
		?>
				
        	<div class="row">
            	<div class="col text-left">
            		<a href="">Plus récents</a>
            	</div>
            	<div class="col text-center">
            		<a href="index.html">Retour</a>
            	</div>
            	<div class="col text-right">
            		<a href="">Plus anciens</a>
            	</div>    		
            </div>    		
		</div>
		<div class="col-md-4">    			
			<h4>Catégories</h4>
			<ul>
				<li>PHP (2)</li>
				<li>Symfony (1)</li>
				<li>Serveur (1)</li>
				<li>Algorythme (1)</li>
				<li>Pi (1)</li>
			</ul>    			
			<hr />    			
			<h4>Derniers articles</h4>
			<ul>
				<li>Blablabla 1</li>
				<li>Blablabla 2</li>
				<li>Blablabla 3</li>
			</ul>    			
			<hr />    			
			<h4>Articles les plus commentés</h4>
			<ul>
				<li>Blablabla 1</li>
				<li>Blablabla 2</li>
				<li>Blablabla 3</li>
			</ul>    			
		</div>
	</div>            		
</main>

<br />
		    
<?php
		$viewContent = ob_get_contents();
		ob_end_clean();
				
		return $viewContent;
	}
}
