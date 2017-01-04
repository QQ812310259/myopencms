<?php
/**
 * Created by PhpStorm.
 * User: Jess
 * Github: https://github.com/jessppp
 */
function chack_array($array){
	if(is_array($array)){
		foreach( $array as $k=> $v){
			if( !$v )
				unset( $array[$k] );
		}
		$array	=	array_pop($array);
	}
	return $array;
}