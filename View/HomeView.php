<?php

namespace View;

class HomeView implements ViewInterface
{
    const HOME_DATA_FILE = __DIR__ . '/../config/home.data.php';
    
    public function render($parameters)
    {
        $data = include(self::HOME_DATA_FILE);
        
        $lastArticles = iterator_to_array($parameters['lastArticles']);
        
        ob_start ();
?>

<header>

	<div class="header-background"></div>
	<div class="header-content">
		<div class="row header-top">
			<div class="col-md-5">
				<img id="my-photo" src="me_real.jpg" />
			</div>
			<div class="col-md-7">
				<h2 id="header-bonjour">Bonjour !</h2>
				<h1>
					Je suis <strong><?php echo $data['username'] ?></strong>
				</h1>
				<h3>Développeur Web Fullstack</h3>
				<hr />
				<div class="row">
					<div class="col-sm-4 text-right">Âge</div>
					<div class="col-sm-8"><?php echo $data['age'] ?> ans</div>
				</div>
				<div class="row">
					<div class="col-sm-4 text-right">Adresse</div>
					<div class="col-sm-8"><?php echo $data['adresse'] ?><br /><?php echo $data['cp'] ?> <?php echo $data['ville']?></div>
				</div>
				<div class="row">
					<div class="col-sm-4 text-right">E-mail</div>
					<div class="col-sm-8"><?php echo $data['email'] ?></div>
				</div>
				<div class="row">
					<div class="col-sm-4 text-right">Téléphone</div>
					<div class="col-sm-8"><?php echo $data['telephone'] ?></div>
				</div>
				<div class="mt-5 text-center">
					<a href="/CV BILLETTE Benjamin - Developpeur Web.pdf" download="CV BILLETTE Benjamin - Developpeur Web.pdf" id="download-resume-btn" class="btn btn-lg">DOWNLOAD RESUME</a>
				</div>
			</div>
		</div>

		<div class="row header-footer">
			<?php foreach ($data['links'] as $link) { ?>				
				<div class="col text-center">
					<a class="one-link" href="<?= $link['href'] ?>" target="_blank">
						<?= $link['icon'] ?>
					</a>
				</div>
			<?php } ?>
		</div>

	</div>


</header>

<main id="home" class="text-center">

<div id="before-description"></div>
<div id="description" class="portfolio-part">
	<h2>A propos</h2>
	<p>
    	<?= $data['description'] ?>          		  
    </p>
</div>

<div id="before-blog"></div>
<div id="blog" class="portfolio-part">
	<h2>
		<a href="/blog">Blog</a>
	</h2>
	<div id="blog-carrousel">		
		<div id="blog-carrousel-container" data-count="<?php echo count($lastArticles) ?>" data-position="0">
			<?php
                $smallButtons = '';
                foreach ($lastArticles as $index => $article) {
                    $smallButtons .= '
                        <div class="blog-carrousel-small-btn" data-index="'.($index).'"></div>';
            ?>			
    			<div class="blog-carrousel-article" style="left: <?php echo $index*100 ?>%" data-init-left="<?php echo $index*100; ?>">
    				<p class="blog-carrousel-article-date">Le <?= $article->getCreatedAt() ?></p>
    				<p class="blog-carrousel-article-title"><?= $article->getTitle() ?></p>
    				<p><a href="/article/<?= $article->getId() ?>">Lire l'article</a></p>
    			</div>
			<?php } ?>			
		</div>
		<div class="blog-carrousel-articles-configuration">
			<?= $smallButtons ?>
		</div>
	</div>
</div>

<!--<div id="twitter_section">--> <!--<h2>Twitter Section</h2>--> <!--</div>-->

<div id="before-skills"></div>
<div id="skills" class="portfolio-part">
	<h2>Compétences</h2>
	<div class="card">
		<div class="card-body">
			<div class="row">
				<?php foreach ($data['skills'] as $skill) { ?>
			  		<div class="col">
			  			<?php echo $skill['icon'] ?>						
						<h4><?php echo $skill['name'] ?></h4>
						<?php echo $skill['content'] ?>				
			  		</div>
		  		<?php } ?>		  		
			</div>
		</div>
	</div>
</div>

<div id="before-technologies"></div>
<div id="technologies" class="portfolio-part">
	<h2>Technologies</h2>
	<div class="card">
		<div class="card-body text-left">			
			<?php foreach ($data['technologies'] as $technology) { ?>
				<?php echo $technology['name'] ?>            
                <div class="progress">
				<div class="progress-bar" role="progressbar" style="width: <?php echo $technology['level'] ?>%" aria-valuenow="<?php echo $technology['level'] ?>" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
			<br />
            <?php } ?>
          </div>
	</div>
</div>

<div id="before-experience"></div>
<div id="experience" class="portfolio-part">
	<h2>Expérience</h2>
	<div class="card card-special">
		<div class="card-body">
          	<?php foreach ($data['experiences'] as $experience) { ?>
				<p><?= $experience['date'] ?></p>
				<p>
					<strong><?= $experience['name'] ?></strong>
				</p>
				<p><?= $experience['content'] ?></p>
				<table class="table">
    				<?php foreach ($experience['missions'] as $index => $mission) { ?>
    					<tr>
							<td><?= $mission['name'] ?></td>
							<td>
								<a class="#" data-toggle="collapse" href="#mission<?= $index ?>Details" role="button" aria-expanded="false" aria-controls="collapseExample">
									Plus de détails
								</a>								
                			</td>
						</tr>
						<tr>							
							<td colspan="2">
								<div class="collapse" id="mission<?= $index ?>Details">
                    				<?= $mission['content'] ?>                    			  
                    			</div>
							</td>
						</tr>
					<?php } ?>
    			</table>
			<?php } ?>
		  </div>
	</div>
</div>

<div id="before-education"></div>
<div id="education" class="portfolio-part">
	<h2>Formation</h2>
	<div class="card card-special">
		<div class="card-body">
          	<?php foreach ($data['formations'] as $index => $formation) { ?>
          		<p>
          			<?= $formation['date'] ?><br /> <strong><?= $formation['name'] ?></strong><br />
          			<?= $formation['school'] ?><br /> <a class="#" data-toggle="collapse" href="#formation<?= $index ?>Details" role="button" aria-expanded="false" aria-controls="collapseExample">
						Plus de détails
					</a>			
			
					<div class="collapse" id="formation<?= $index ?>Details">				    			  		
			  			<?= $formation['content'] ?>
    				</div>
				</p>
         	<?php } ?>
		  </div>
	</div>
</div>

<div id="before-portfolio"></div>
<div id="portfolio" class="portfolio-part">
	<h2>Portfolio</h2>
		<?php echo $data['portfolio']['description'] ?><br />
	<br />
	<div class="row">
			<?php foreach ($data['portfolio']['content'] as $project) { ?>
				<div class="col-md-4">
			<img src="<?php echo $project['src'] ?>" width="100%" />
			<h4><?php echo $project['name'] ?></h4>
		</div>
			<?php } ?>
		</div>
</div>

<div id="before-interests"></div>
<div id="interests" class="portfolio-part">
	<h2>Centres d'intérêts</h2>
	
			<?php
			     foreach ($data['interests'] as $index => $interest) {
			         			             
			?>			
    			<div class="row">				
    				<div class="text-left col-sm-6 offset-sm-0 col-md-8 offset-md-2">
    					<img class="mr-3" src="https://source.unsplash.com/random/150x150" />    				
    					<?php //echo $interest['icon'] ?> Interest's name
    				</div>
    			</div>
	         <?php } ?>
		
</div>

<!--<div id="clients"></div>--> <!--<div id="references"></div>-->

<div id="before-contact"></div>
<div id="contact" class="portfolio-part">
	<h2>Contact</h2>
	<p>N'hésitez pas, envoyez-moi un courriel :</p>
	<p><i class="far fa-envelope"></i></p>
	<p><?php echo $data['email'] ?></p>
</div>

</main>

<footer class="text-center">
	<h3>A bientôt !</h3>
</footer>

<br />

<?php
        $viewContent = ob_get_contents();
        ob_end_clean();
        
        return $viewContent;
    }
}
