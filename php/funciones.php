<?php	
	function texto($var){
		$exp="/^[a-zaeiou\s]{3,25}$/i";
		return preg_match($exp, $var);
	}
	function fecha_f($var){
		$exp="/^(0?[1-9]|1[0-9]|2[0-9]|3[0-1])(\/)(0?[1-9]|1[0-2])(\/)(199[6-9]|20[0-1][0-9])$/";
		return preg_match($exp,$var);
	}
	function foto_f($var){
		$exp="/^.+(.jpe?g)$/i";
		return preg_match($exp,$var); 
	}
	function email_f($var){
		$exp="/^[a-zA-Z\d\-\.]{3,25}@[a-z]{3,15}\.[a-z]{2,4}$/";
		return preg_match($exp, $var);
	}
	function cont($var){
		$exp="/^[a-zA-Z\d_#,;~@%&\\\!\$\^\*\(\)\-\+\=\{\}\[\]\:\'\\<\>\.\?\|]{3,15}$/";
		return preg_match($exp, $var);
	}
	function calle_f($var){
		$exp="/^([\w\d\]+)?$/i";
		return preg_match($exp,$var); 
	}
	function telefono($var){
		$exp="/^[\d\s\-]{1,15}$/";
		return preg_match($exp,$var); 
	}
	?>