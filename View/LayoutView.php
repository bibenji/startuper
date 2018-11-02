<?php

namespace View;

class LayoutView implements ViewInterface
{
    public function render($parameters)
    {
        $content = $parameters ['content'];
        
        ob_start ();
        
        ?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="https://getbootstrap.com/favicon.ico">

<title>Startuper - Blog</title>

<!-- Bootstrap core CSS -->
<link
	href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
	rel="stylesheet">

<!-- Custom fonts for this template -->
<!-- <link href="assets/fonts/stylesheet.css"> -->
<!-- Custom styles for this template -->
<link href="/startuper.css" rel="stylesheet">

<link rel="stylesheet"
	href="https://use.fontawesome.com/releases/v5.1.0/css/all.css"
	integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt"
	crossorigin="anonymous">
</head>

<body>

	<navbar class="custom-navbar" data-bolded="0">
	<ul id="menu-expanded">
		<li><a id="description-link" href="/#before-description">A propos</a></li>
		<li><a id="blog-link" href="/#before-blog">Blog</a></li>
		<li><a id="skills-link" href="/#before-skills">Compétences</a></li>
		<li><a id="technologies-link" href="/#before-technologies">Technologies</a></li>
		<li><a id="experience-link" href="/#before-experience">Expérience</a></li>
		<li><a id="education-link" href="/#before-education">Formation</a></li>
		<li><a id="portfolio-link" href="/#before-portfolio">Portfolio</a></li>
		<li><a id="interests-link" href="/#before-interests">Centres d'intérêts</a></li>
		<li><a id="contact-link" href="/#before-contact">Contact</a></li>
	</ul>
	<ul id="menu-burger">
		<li>
			<button class="menu-burger-btn">
				<i class="fas fa-bars"></i>
			</button>
		</li>
	</ul>
	</navbar>

		<?php echo $content ?>    		
        
    <!-- Bootstrap core JavaScript ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"
		integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
		crossorigin="anonymous"></script>
	<!--<script src="index_files/jquery-3.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
	<!--<script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script>
        	$(function() {
        		
        		$('.menu-burger-btn, .custom-navbar a').click(function() {				
        			$('.custom-navbar').toggleClass('custom-navbar-visible');
        		});        		

// 				$('#articles-small-btn-1, #articles-small-btn-2').hide();				

				// -----------------------------------------------------------------------------------
				// ------------------------------------ CARROUSEL ------------------------------------
				// -----------------------------------------------------------------------------------
								
				function displayCarrouselSmallButtons() {
					const carrouselPosition = $('#blog-carrousel-container').data('position');

					$('.blog-carrousel-small-btn').each(function(index, smallButton) {
						if ($(smallButton).data('index') != carrouselPosition) {
							$(smallButton).removeClass('active');
						} else {
							$(smallButton).addClass('active');
						}
					});
				}

				displayCarrouselSmallButtons();

				function switchCarrouselPosition(newCarrouselPosition)
				{
					$('#blog-carrousel-container').data('position', newCarrouselPosition);
					
					$('.blog-carrousel-article').each(function(index, elem) {
						var newLeft = $(elem).data('init-left')-(100*newCarrouselPosition);						
						$(elem).attr('style', 'left: '+newLeft+'%');
					});	

					displayCarrouselSmallButtons();				
				}
				
				setInterval(function() {
					
					var carrouselPosition = $('#blog-carrousel-container').data('position');					

					if (carrouselPosition+1 == $('#blog-carrousel-container').data('count')) {
						carrouselPosition = -1;
					}

					carrouselPosition++;					
					
					switchCarrouselPosition(carrouselPosition);					
									
				}, 3000);

				$('#blog-carrousel').on('click', '.blog-carrousel-small-btn', function(event) {
					switchCarrouselPosition($(event.target).data('index'));
				});

				// -----------------------------------------------------------------------------------
				// ------------------------------------ APPEARING ------------------------------------
				// -----------------------------------------------------------------------------------
				
        		var appearingElements = $('#description, #blog, #skills, #technologies, #experience, #education, #portfolio, #interests, #contact'); 
        		var navbarH = 100;
				
				appearingElements
					.css({
						top: 50,
						position: 'relative',
						opacity: '0'
					})
					.data('displayed', 0)
				;

				function toggleActiveLink(that) {
					const wH = $(window).height()-navbarH;
					const wS = $(window).scrollTop()+navbarH;					
					
					const tH = $(that).outerHeight();
					const tS = $(that).offset().top;

					// rH = hauteur de référence
// 					const rH = wS+(wH/2); // milieu de fenêtre
					const rH = wS; // haut de fenêtre
					
					const target = '#' + $(that).attr('id') + '-link';
					
					if ( (tS < rH && (tS+tH) > rH ) ) {											
						console.log(target);
						$(target).addClass('lien-actif');						
					} else {
						$(target).removeClass('lien-actif');
					}
				}
				

				function displayAppearingElements(that) {
					var wH = $(window).height();
					var wS = $(window).scrollTop();					
					
					var tH = $(that).outerHeight();
					var tS = $(that).offset().top;

					if (
						((wS+wH) >= tS) &&
						((wS+navbarH) < (tS+tH))
					) {
						$(that)
							.css({
								top: 50,
								position: 'relative',
								opacity: '0'
							})
							.animate({'top': 0, 'opacity': '1'}, 500)        
						;
						$(that).data('displayed', 1);
					}					
				}       		
        		
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

					appearingElements.each(function(index, div) {

						toggleActiveLink(this);
									
						if ($(div).data('displayed') == 0) {
							displayAppearingElements(this);					
						}						
					});     			
        		});        		
        		
        	});
        
        </script>

</body>

</html>

<?php
        
        $viewContent = ob_get_contents ();
        ob_end_clean ();
        
        return $viewContent;
    }
}
