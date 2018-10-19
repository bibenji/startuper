<?php

namespace View;

class ArticleView implements ViewInterface
{   
    public function render($parameters)
    {           
        ob_start();        
?>

<h1>ArticleView.php</h1>
        
<?php
		$viewContent = ob_get_contents();
		ob_end_clean();
		
		return $viewContent;
	}
}