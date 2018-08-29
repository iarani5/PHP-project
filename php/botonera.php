<?php 
echo "<ul>";
	foreach( $links as $texto => $href ){
		echo '<li><a href="index.php?boton='.$href.'">'.$texto.'</a></li>';
	}	
	echo "</ul>";
?>



