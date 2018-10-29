<?php ?>

<h4>Catégories</h4>
<ul>
	<?php foreach ($countByCategories as $category) { ?>
		<li><?php echo $category['name'] ?> (<a href="/blog?category=<?php echo strtolower($category['name']) ?>"><?php echo $category['count'] ?></a>)</li>
	<?php } ?>	
</ul>

<hr />

<h4>Derniers articles</h4>
<ul>
	<?php foreach ($lastArticles as $article) { ?>
		<li><a href="/article/<?php echo $article->getId() ?>"><?php echo $article->getTitle() ?></a></li>
	<?php } ?>
</ul>

<hr />

<!-- <h4>Articles les plus commentés</h4> -->
<!-- <ul> -->
<!-- 	<li>Blablabla 1</li> -->
<!-- 	<li>Blablabla 2</li> -->
<!-- 	<li>Blablabla 3</li> -->
<!-- </ul> -->
		
<?php