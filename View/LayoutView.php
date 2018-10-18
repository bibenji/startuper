<?php

namespace View;

class LayoutView implements ViewInterface
{
	public function render($parameters)
	{	
		$content = $parameters['content'];
		
		ob_start();
		
		?>

		<!DOCTYPE html>
		<html lang="en"><head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		    <meta charset="utf-8">
		    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		    <meta name="description" content="">
		    <meta name="author" content="">
		    <link rel="icon" href="https://getbootstrap.com/favicon.ico">
		
		    <title>Startuper - Blog</title>
		
		    <!-- Bootstrap core CSS -->
		    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
		
		    <!-- Custom fonts for this template -->
			<!-- <link href="assets/fonts/stylesheet.css"> -->
		    <!-- Custom styles for this template -->
		    <link href="startuper.css" rel="stylesheet">
		
		    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
		  </head>
		
		  <body>
		  
			<navbar class="custom-navbar" data-bolded="0">        
				<ul id="menu-expanded">
					<li><a href="#before-description">A propos</a></li>
					<li class="lien-actif"><a href="#before-blog">Blog</a></li>
					<li><a href="#before-skills">Compétences</a></li>
					<li><a href="#before-technologies">Technologies</a></li>
					<li><a href="#before-experience">Expérience</a></li>
					<li><a href="#before-education">Formation</a></li>
					<li><a href="#before-portfolio">Portfolio</a></li>
					<li><a href="#before-interests">Centres d'intérêts</a></li>
					<li><a href="#before-contact">Contact</a></li>
				</ul>
				<ul id="menu-burger">
					<li>
						<button class="menu-burger-btn">
							<i class="fas fa-bars"></i>
						</button>
					</li>
					
				</ul>
		    </navbar>
		    	
		    	<div style="height: 75px;"></div>  	
		      		
				<!-- <h1 class="text-center">Blog</h1> -->
		
			<style>
				main {
					font-size: 90%;			
				}
				
				main .card {
					margin-bottom: 30px;
					border-top: solid 5px rgb(26, 119, 212);
				}
				main .card-body img {
					width: 100%;
				}
				
				main ul {
					list-style: circle inside;
					margin: 0px;	
					padding: 0px;		
				}
				main ul li {
					border-bottom: solid 1px #c6c6c6;
					padding: 10px 0px;		
				}
				main ul li:last-of-type {
					border-bottom: none;
				}
				
				footer {
				  padding: 5px;
		  			margin: 0px auto;  
		  			width: 1000px;
		  			max-width: 90%;
				}
			
			</style>
		
		    <main>
		    
		    	
		    
		    	<div class="row">
		    		<div class="col-md-8">
		    		
		    			<?php echo $content ?>
		    				
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
		    
		    <footer>
		    
		    </footer>
		    
		    <br />
		
		
		
		
		
		
		
		
		      <!--<div class="starter-template">-->
		        <!--<h1>Bootstrap starter template</h1>-->
		        <!--<p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text and a mostly barebones HTML document.</p>-->
		      <!--</div>-->
		
		
		
		    <!-- Bootstrap core JavaScript
		    ================================================== -->
		    <!-- Placed at the end of the document so the pages load faster -->
		    <script
		      src="https://code.jquery.com/jquery-3.3.1.min.js"
		      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
		      crossorigin="anonymous"></script>
		    <!--<script src="index_files/jquery-3.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
		    <!--<script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>-->
		    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/popper.min.js"></script>
		    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
			
			<script>
				$(function() {
					console.log('jQuery ready');	
					
					$('.menu-burger-btn').click(function() {				
						$('.custom-navbar').toggleClass('custom-navbar-visible');
					});
					
					
					$(window).scroll(function() {
						
						var that = this;
						
						if ($(window).scrollTop() > 10 && $('.custom-navbar').data('bolded') === 0) {
							$('.custom-navbar').toggleClass('custom-navbar-bolded');
							$('.custom-navbar').data('bolded', 1);
						}
						if ($(window).scrollTop() < 10 && $('.custom-navbar').data('bolded') === 1) {
							$('.custom-navbar').toggleClass('custom-navbar-bolded');
							$('.custom-navbar').data('bolded', 0);
						}
						
					});
					
				});
			
			</script>
			
		</body></html>

		<?php		
		
		$viewContent = ob_get_contents();
		ob_end_clean();
		
		return $viewContent;
	}
}
