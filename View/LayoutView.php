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
		<li><a href="/#before-description">A propos</a></li>
		<li class="lien-actif"><a href="/#before-blog">Blog</a></li>
		<li><a href="/#before-skills">Compétences</a></li>
		<li><a href="/#before-technologies">Technologies</a></li>
		<li><a href="/#before-experience">Expérience</a></li>
		<li><a href="/#before-education">Formation</a></li>
		<li><a href="/#before-portfolio">Portfolio</a></li>
		<li><a href="/#before-interests">Centres d'intérêts</a></li>
		<li><a href="/#before-contact">Contact</a></li>
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
        		console.log('jQuery ready');	
        		
        		$('.menu-burger-btn').click(function() {				
        			$('.custom-navbar').toggleClass('custom-navbar-visible');
        		});

				$('#articles-small-btn-1, #articles-small-btn-2').hide();				
				
				setInterval(function() {
					if ($('#articles-carrousel-container').data('position') === 1) {
						console.log('position2');
						$('#articles-carrousel-container').toggleClass('carrousel-position1');
						$('#articles-carrousel-container').toggleClass('carrousel-position2');
						$('#articles-carrousel-container').data('position', 2);
						$('#articles-small-btn-1, #articles-small-btn-5').hide();
						$('#articles-small-btn-2, #articles-small-btn-4').show();
					} else if ($('#articles-carrousel-container').data('position') === 2) {
						console.log('position3');
						$('#articles-carrousel-container').toggleClass('carrousel-position2');
						$('#articles-carrousel-container').toggleClass('carrousel-position3');
						$('#articles-carrousel-container').data('position', 3);
						$('#articles-small-btn-4, #articles-small-btn-5').hide();
						$('#articles-small-btn-1, #articles-small-btn-2').show();						
					} else {
						console.log('position1');
						$('#articles-carrousel-container').toggleClass('carrousel-position3');
						$('#articles-carrousel-container').toggleClass('carrousel-position1');
						$('#articles-carrousel-container').data('position', 1);
						$('#articles-small-btn-1, #articles-small-btn-2').hide();
						$('#articles-small-btn-4, #articles-small-btn-5').show();
					}					
				}, 2000);        					
				        				
				$('#skills, #technologies, #experience, #education')
					.css({
						top: 50,
						position: 'relative',
						opacity: '0'
					})
				;       		
        		
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

					$('#skills, #technologies, #experience, #education').each(function(index, div) {						
						if ($(div).data('displayed') == 0) {
							var hT = $(div).offset().top;
							var hH = $(div).outerHeight();
							var wH = $(window).height();
							var wS = $(that).scrollTop();
					
							// ajout de 75 pour démarrer l'animation légèrement plus tôt
							if ((wS+75) > (hT+hH-wH)) {					
								$(div)
									.css({
										top: 50,
										position: 'relative',
										opacity: '0'
									})
									.animate({'top': 0, 'opacity': '1'}, 500)        
								;
								$(div).data('displayed', 1);
							}					
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
