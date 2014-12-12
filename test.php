<?php
	function clean( $string ) {
		$string = str_replace(" ", "", $string); // Replaces all spaces.
		$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
		return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
	}
	
	print clean('Qsdf  sdf sd d d  f  s  df sdf');
?>